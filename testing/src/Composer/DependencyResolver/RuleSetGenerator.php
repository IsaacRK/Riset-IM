<?php











namespace Composer\DependencyResolver;

use Composer\Package\BasePackage;
use Composer\Package\AliasPackage;
use Composer\Repository\PlatformRepository;





class RuleSetGenerator
{

protected $policy;

protected $pool;

protected $rules;

protected $addedMap = array();

protected $addedPackagesByNames = array();

public function __construct(PolicyInterface $policy, Pool $pool)
{
$this->policy = $policy;
$this->pool = $pool;
$this->rules = new RuleSet;
}















protected function createRequireRule(BasePackage $package, array $providers, $reason, $reasonData = null)
{
$literals = array(-$package->id);

foreach ($providers as $provider) {

if ($provider === $package) {
return null;
}
$literals[] = $provider->id;
}

return new GenericRule($literals, $reason, $reasonData);
}















protected function createInstallOneOfRule(array $packages, $reason, $reasonData)
{
$literals = array();
foreach ($packages as $package) {
$literals[] = $package->id;
}

return new GenericRule($literals, $reason, $reasonData);
}















protected function createRule2Literals(BasePackage $issuer, BasePackage $provider, $reason, $reasonData = null)
{

if ($issuer === $provider) {
return null;
}

return new Rule2Literals(-$issuer->id, -$provider->id, $reason, $reasonData);
}









protected function createMultiConflictRule(array $packages, $reason, $reasonData)
{
$literals = array();
foreach ($packages as $package) {
$literals[] = -$package->id;
}

if (\count($literals) == 2) {
return new Rule2Literals($literals[0], $literals[1], $reason, $reasonData);
}

return new MultiConflictRule($literals, $reason, $reasonData);
}












private function addRule($type, Rule $newRule = null)
{
if (!$newRule) {
return;
}

$this->rules->add($newRule, $type);
}





protected function addRulesForPackage(BasePackage $package, $ignorePlatformReqs)
{

$workQueue = new \SplQueue;
$workQueue->enqueue($package);

while (!$workQueue->isEmpty()) {
$package = $workQueue->dequeue();
if (isset($this->addedMap[$package->id])) {
continue;
}

$this->addedMap[$package->id] = $package;

if (!$package instanceof AliasPackage) {
foreach ($package->getNames(false) as $name) {
$this->addedPackagesByNames[$name][] = $package;
}
} else {
$workQueue->enqueue($package->getAliasOf());
$this->addRule(RuleSet::TYPE_PACKAGE, $this->createRequireRule($package, array($package->getAliasOf()), Rule::RULE_PACKAGE_ALIAS, $package));


$this->addRule(RuleSet::TYPE_PACKAGE, $this->createRequireRule($package->getAliasOf(), array($package), Rule::RULE_PACKAGE_INVERSE_ALIAS, $package->getAliasOf()));



if (!$package->hasSelfVersionRequires()) {
continue;
}
}

foreach ($package->getRequires() as $link) {
if ((true === $ignorePlatformReqs || (is_array($ignorePlatformReqs) && in_array($link->getTarget(), $ignorePlatformReqs, true))) && PlatformRepository::isPlatformPackage($link->getTarget())) {
continue;
}

$possibleRequires = $this->pool->whatProvides($link->getTarget(), $link->getConstraint());

$this->addRule(RuleSet::TYPE_PACKAGE, $this->createRequireRule($package, $possibleRequires, Rule::RULE_PACKAGE_REQUIRES, $link));

foreach ($possibleRequires as $require) {
$workQueue->enqueue($require);
}
}
}
}





protected function addConflictRules($ignorePlatformReqs = false)
{

foreach ($this->addedMap as $package) {
foreach ($package->getConflicts() as $link) {

if (!isset($this->addedPackagesByNames[$link->getTarget()])) {
continue;
}

if ((true === $ignorePlatformReqs || (is_array($ignorePlatformReqs) && in_array($link->getTarget(), $ignorePlatformReqs, true))) && PlatformRepository::isPlatformPackage($link->getTarget())) {
continue;
}

$conflicts = $this->pool->whatProvides($link->getTarget(), $link->getConstraint());

foreach ($conflicts as $conflict) {



if (!$conflict instanceof AliasPackage || $conflict->getName() === $link->getTarget()) {
$this->addRule(RuleSet::TYPE_PACKAGE, $this->createRule2Literals($package, $conflict, Rule::RULE_PACKAGE_CONFLICT, $link));
}
}
}
}

foreach ($this->addedPackagesByNames as $name => $packages) {
if (\count($packages) > 1) {
$reason = Rule::RULE_PACKAGE_SAME_NAME;
$this->addRule(RuleSet::TYPE_PACKAGE, $this->createMultiConflictRule($packages, $reason, $name));
}
}
}





protected function addRulesForRequest(Request $request, $ignorePlatformReqs)
{
foreach ($request->getFixedPackages() as $package) {
if ($package->id == -1) {

if ($this->pool->isUnacceptableFixedOrLockedPackage($package)) {
continue;
}


throw new \LogicException("Fixed package ".$package->getPrettyString()." was not added to solver pool.");
}

$this->addRulesForPackage($package, $ignorePlatformReqs);

$rule = $this->createInstallOneOfRule(array($package), Rule::RULE_FIXED, array(
'package' => $package,
));
$this->addRule(RuleSet::TYPE_REQUEST, $rule);
}

foreach ($request->getRequires() as $packageName => $constraint) {
if ((true === $ignorePlatformReqs || (is_array($ignorePlatformReqs) && in_array($packageName, $ignorePlatformReqs, true))) && PlatformRepository::isPlatformPackage($packageName)) {
continue;
}

$packages = $this->pool->whatProvides($packageName, $constraint);
if ($packages) {
foreach ($packages as $package) {
$this->addRulesForPackage($package, $ignorePlatformReqs);
}

$rule = $this->createInstallOneOfRule($packages, Rule::RULE_ROOT_REQUIRE, array(
'packageName' => $packageName,
'constraint' => $constraint,
));
$this->addRule(RuleSet::TYPE_REQUEST, $rule);
}
}
}





protected function addRulesForRootAliases($ignorePlatformReqs)
{
foreach ($this->pool->getPackages() as $package) {



if (!isset($this->addedMap[$package->id]) &&
$package instanceof AliasPackage &&
($package->isRootPackageAlias() || isset($this->addedMap[$package->getAliasOf()->id]))
) {
$this->addRulesForPackage($package, $ignorePlatformReqs);
}
}
}





public function getRulesFor(Request $request, $ignorePlatformReqs = false)
{
$this->addRulesForRequest($request, $ignorePlatformReqs);

$this->addRulesForRootAliases($ignorePlatformReqs);

$this->addConflictRules($ignorePlatformReqs);


$this->addedMap = $this->addedPackagesByNames = array();

$rules = $this->rules;

$this->rules = new RuleSet;

return $rules;
}
}
