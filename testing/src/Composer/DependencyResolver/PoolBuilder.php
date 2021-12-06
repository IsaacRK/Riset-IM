<?php











namespace Composer\DependencyResolver;

use Composer\EventDispatcher\EventDispatcher;
use Composer\IO\IOInterface;
use Composer\Package\AliasPackage;
use Composer\Package\BasePackage;
use Composer\Package\CompleteAliasPackage;
use Composer\Package\CompletePackage;
use Composer\Package\PackageInterface;
use Composer\Package\Version\StabilityFilter;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PrePoolCreateEvent;
use Composer\Repository\PlatformRepository;
use Composer\Repository\RepositoryInterface;
use Composer\Repository\RootPackageRepository;
use Composer\Semver\CompilingMatcher;
use Composer\Semver\Constraint\Constraint;
use Composer\Semver\Constraint\ConstraintInterface;
use Composer\Semver\Constraint\MatchAllConstraint;
use Composer\Semver\Constraint\MultiConstraint;
use Composer\Semver\Intervals;




class PoolBuilder
{




private $acceptableStabilities;




private $stabilityFlags;




private $rootAliases;




private $rootReferences;



private $eventDispatcher;



private $io;




private $aliasMap = array();




private $packagesToLoad = array();




private $loadedPackages = array();




private $loadedPerRepo = array();



private $packages = array();



private $unacceptableFixedOrLockedPackages = array();

private $updateAllowList = array();

private $skippedLoad = array();











private $maxExtendedReqs = array();




private $updateAllowWarned = array();


private $indexCounter = 0;











public function __construct(array $acceptableStabilities, array $stabilityFlags, array $rootAliases, array $rootReferences, IOInterface $io, EventDispatcher $eventDispatcher = null)
{
$this->acceptableStabilities = $acceptableStabilities;
$this->stabilityFlags = $stabilityFlags;
$this->rootAliases = $rootAliases;
$this->rootReferences = $rootReferences;
$this->eventDispatcher = $eventDispatcher;
$this->io = $io;
}





public function buildPool(array $repositories, Request $request)
{
if ($request->getUpdateAllowList()) {
$this->updateAllowList = $request->getUpdateAllowList();
$this->warnAboutNonMatchingUpdateAllowList($request);

foreach ($request->getLockedRepository()->getPackages() as $lockedPackage) {
if (!$this->isUpdateAllowed($lockedPackage)) {
$request->lockPackage($lockedPackage);
$lockedName = $lockedPackage->getName();

$this->skippedLoad[$lockedName] = $lockedName;
foreach ($lockedPackage->getReplaces() as $link) {
$this->skippedLoad[$link->getTarget()] = $lockedName;
}
}
}
}

foreach ($request->getFixedOrLockedPackages() as $package) {


$this->loadedPackages[$package->getName()] = new MatchAllConstraint();


foreach ($package->getReplaces() as $link) {
$this->loadedPackages[$link->getTarget()] = new MatchAllConstraint();
}




if (
$package->getRepository() instanceof RootPackageRepository
|| $package->getRepository() instanceof PlatformRepository
|| StabilityFilter::isPackageAcceptable($this->acceptableStabilities, $this->stabilityFlags, $package->getNames(), $package->getStability())
) {
$this->loadPackage($request, $package, false);
} else {
$this->unacceptableFixedOrLockedPackages[] = $package;
}
}

foreach ($request->getRequires() as $packageName => $constraint) {

if (isset($this->loadedPackages[$packageName])) {
continue;
}

$this->packagesToLoad[$packageName] = $constraint;
$this->maxExtendedReqs[$packageName] = true;
}


foreach ($this->packagesToLoad as $name => $constraint) {
if (isset($this->loadedPackages[$name])) {
unset($this->packagesToLoad[$name]);
}
}

while (!empty($this->packagesToLoad)) {
$this->loadPackagesMarkedForLoading($request, $repositories);
}

foreach ($this->packages as $i => $package) {


if (!$package instanceof AliasPackage) {
$constraint = new Constraint('==', $package->getVersion());
$aliasedPackages = array($i => $package);
if (isset($this->aliasMap[spl_object_hash($package)])) {
$aliasedPackages += $this->aliasMap[spl_object_hash($package)];
}

$found = false;
foreach ($aliasedPackages as $packageOrAlias) {
if (CompilingMatcher::match($constraint, Constraint::OP_EQ, $packageOrAlias->getVersion())) {
$found = true;
}
}
if (!$found) {
foreach ($aliasedPackages as $index => $packageOrAlias) {
unset($this->packages[$index]);
}
}
}
}

if ($this->eventDispatcher) {
$prePoolCreateEvent = new PrePoolCreateEvent(
PluginEvents::PRE_POOL_CREATE,
$repositories,
$request,
$this->acceptableStabilities,
$this->stabilityFlags,
$this->rootAliases,
$this->rootReferences,
$this->packages,
$this->unacceptableFixedOrLockedPackages
);
$this->eventDispatcher->dispatch($prePoolCreateEvent->getName(), $prePoolCreateEvent);
$this->packages = $prePoolCreateEvent->getPackages();
$this->unacceptableFixedOrLockedPackages = $prePoolCreateEvent->getUnacceptableFixedPackages();
}

$pool = new Pool($this->packages, $this->unacceptableFixedOrLockedPackages);

$this->aliasMap = array();
$this->packagesToLoad = array();
$this->loadedPackages = array();
$this->loadedPerRepo = array();
$this->packages = array();
$this->unacceptableFixedOrLockedPackages = array();
$this->maxExtendedReqs = array();
$this->skippedLoad = array();
$this->indexCounter = 0;

Intervals::clear();

return $pool;
}





private function markPackageNameForLoading(Request $request, $name, ConstraintInterface $constraint)
{

if (PlatformRepository::isPlatformPackage($name)) {
return;
}



if (isset($this->maxExtendedReqs[$name])) {
return;
}





$rootRequires = $request->getRequires();
if (isset($rootRequires[$name]) && !Intervals::isSubsetOf($constraint, $rootRequires[$name])) {
$constraint = $rootRequires[$name];
}


if (!isset($this->loadedPackages[$name])) {



if (isset($this->packagesToLoad[$name])) {

if (Intervals::isSubsetOf($constraint, $this->packagesToLoad[$name])) {
return;
}


$constraint = Intervals::compactConstraint(MultiConstraint::create(array($this->packagesToLoad[$name], $constraint), false));
}

$this->packagesToLoad[$name] = $constraint;

return;
}



if (Intervals::isSubsetOf($constraint, $this->loadedPackages[$name])) {
return;
}




$this->packagesToLoad[$name] = Intervals::compactConstraint(MultiConstraint::create(array($this->loadedPackages[$name], $constraint), false));
unset($this->loadedPackages[$name]);
}





private function loadPackagesMarkedForLoading(Request $request, $repositories)
{
foreach ($this->packagesToLoad as $name => $constraint) {
$this->loadedPackages[$name] = $constraint;
}

$packageBatch = $this->packagesToLoad;
$this->packagesToLoad = array();

foreach ($repositories as $repoIndex => $repository) {
if (empty($packageBatch)) {
break;
}



if ($repository instanceof PlatformRepository || $repository === $request->getLockedRepository()) {
continue;
}
$result = $repository->loadPackages($packageBatch, $this->acceptableStabilities, $this->stabilityFlags, isset($this->loadedPerRepo[$repoIndex]) ? $this->loadedPerRepo[$repoIndex] : array());

foreach ($result['namesFound'] as $name) {

unset($packageBatch[$name]);
}
foreach ($result['packages'] as $package) {
$this->loadedPerRepo[$repoIndex][$package->getName()][$package->getVersion()] = $package;
$this->loadPackage($request, $package);
}
}
}





private function loadPackage(Request $request, BasePackage $package, $propagateUpdate = true)
{
$index = $this->indexCounter++;
$this->packages[$index] = $package;

if ($package instanceof AliasPackage) {
$this->aliasMap[spl_object_hash($package->getAliasOf())][$index] = $package;
}

$name = $package->getName();




if (isset($this->rootReferences[$name])) {

if (!$request->isLockedPackage($package) && !$request->isFixedPackage($package)) {
$package->setSourceDistReferences($this->rootReferences[$name]);
}
}



if ($propagateUpdate && isset($this->rootAliases[$name][$package->getVersion()])) {
$alias = $this->rootAliases[$name][$package->getVersion()];
if ($package instanceof AliasPackage) {
$basePackage = $package->getAliasOf();
} else {
$basePackage = $package;
}
if ($basePackage instanceof CompletePackage) {
$aliasPackage = new CompleteAliasPackage($basePackage, $alias['alias_normalized'], $alias['alias']);
} else {
$aliasPackage = new AliasPackage($basePackage, $alias['alias_normalized'], $alias['alias']);
}
$aliasPackage->setRootPackageAlias(true);

$newIndex = $this->indexCounter++;
$this->packages[$newIndex] = $aliasPackage;
$this->aliasMap[spl_object_hash($aliasPackage->getAliasOf())][$newIndex] = $aliasPackage;
}

foreach ($package->getRequires() as $link) {
$require = $link->getTarget();
$linkConstraint = $link->getConstraint();


if (isset($this->skippedLoad[$require])) {



if ($propagateUpdate && $request->getUpdateAllowTransitiveDependencies()) {
if ($request->getUpdateAllowTransitiveRootDependencies() || !$this->isRootRequire($request, $this->skippedLoad[$require])) {
$this->unlockPackage($request, $require);
$this->markPackageNameForLoading($request, $require, $linkConstraint);
} elseif (!isset($this->updateAllowWarned[$this->skippedLoad[$require]])) {
$this->updateAllowWarned[$this->skippedLoad[$require]] = true;
$this->io->writeError('<warning>Dependency "'.$this->skippedLoad[$require].'" is also a root requirement. Package has not been listed as an update argument, so keeping locked at old version. Use --with-all-dependencies (-W) to include root dependencies.</warning>');
}
}
} else {
$this->markPackageNameForLoading($request, $require, $linkConstraint);
}
}



if ($propagateUpdate && $request->getUpdateAllowTransitiveDependencies()) {
foreach ($package->getReplaces() as $link) {
$replace = $link->getTarget();
if (isset($this->loadedPackages[$replace], $this->skippedLoad[$replace])) {
if ($request->getUpdateAllowTransitiveRootDependencies() || !$this->isRootRequire($request, $this->skippedLoad[$replace])) {
$this->unlockPackage($request, $replace);
$this->markPackageNameForLoading($request, $replace, $link->getConstraint());
} elseif (!$request->getUpdateAllowTransitiveRootDependencies() && $this->isRootRequire($request, $replace) && !isset($this->updateAllowWarned[$replace])) {
$this->updateAllowWarned[$replace] = true;
$this->io->writeError('<warning>Dependency "'.$replace.'" is also a root requirement. Package has not been listed as an update argument, so keeping locked at old version. Use --with-all-dependencies (-W) to include root dependencies.</warning>');
}
}
}
}
}







private function isRootRequire(Request $request, $name)
{
$rootRequires = $request->getRequires();

return isset($rootRequires[$name]);
}






private function isUpdateAllowed(BasePackage $package)
{



if ($package->getDistType() === 'path') {
$transportOptions = $package->getTransportOptions();
if (!isset($transportOptions['symlink']) || $transportOptions['symlink'] !== false) {
return true;
}
}

foreach ($this->updateAllowList as $pattern => $void) {
$patternRegexp = BasePackage::packageNameToRegexp($pattern);
if (preg_match($patternRegexp, $package->getName())) {
return true;
}
}

return false;
}




private function warnAboutNonMatchingUpdateAllowList(Request $request)
{
foreach ($this->updateAllowList as $pattern => $void) {
$patternRegexp = BasePackage::packageNameToRegexp($pattern);

foreach ($request->getLockedRepository()->getPackages() as $package) {
if (preg_match($patternRegexp, $package->getName())) {
continue 2;
}
}

foreach ($request->getRequires() as $packageName => $constraint) {
if (preg_match($patternRegexp, $packageName)) {
continue 2;
}
}
if (strpos($pattern, '*') !== false) {
$this->io->writeError('<warning>Pattern "' . $pattern . '" listed for update does not match any locked packages.</warning>');
} else {
$this->io->writeError('<warning>Package "' . $pattern . '" listed for update is not locked.</warning>');
}
}
}








private function unlockPackage(Request $request, $name)
{
if (

$this->skippedLoad[$name] !== $name

&& isset($this->skippedLoad[$this->skippedLoad[$name]])
) {
$this->unlockPackage($request, $this->skippedLoad[$name]);
}

unset($this->skippedLoad[$name], $this->loadedPackages[$name], $this->maxExtendedReqs[$name]);


foreach ($request->getLockedPackages() as $lockedPackage) {
if (!($lockedPackage instanceof AliasPackage) && $lockedPackage->getName() === $name) {
if (false !== $index = array_search($lockedPackage, $this->packages, true)) {
$request->unlockPackage($lockedPackage);
$this->removeLoadedPackage($request, $lockedPackage, $index);




foreach ($request->getFixedOrLockedPackages() as $fixedOrLockedPackage) {
if ($fixedOrLockedPackage !== $lockedPackage && isset($this->skippedLoad[$fixedOrLockedPackage->getName()])) {
foreach ($fixedOrLockedPackage->getRequires() as $requireLink) {
if ($requireLink->getTarget() === $lockedPackage->getName()) {
$this->markPackageNameForLoading($request, $lockedPackage->getName(), $requireLink->getConstraint());
}
}
}
}
}
}
}
}





private function removeLoadedPackage(Request $request, BasePackage $package, $index)
{
unset($this->packages[$index]);
if (isset($this->aliasMap[spl_object_hash($package)])) {
foreach ($this->aliasMap[spl_object_hash($package)] as $aliasIndex => $aliasPackage) {
$request->unlockPackage($aliasPackage);
unset($this->packages[$aliasIndex]);
}
unset($this->aliasMap[spl_object_hash($package)]);
}
}
}
