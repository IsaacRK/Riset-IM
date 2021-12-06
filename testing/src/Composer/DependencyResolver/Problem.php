<?php











namespace Composer\DependencyResolver;

use Composer\Package\CompletePackageInterface;
use Composer\Package\AliasPackage;
use Composer\Package\BasePackage;
use Composer\Package\PackageInterface;
use Composer\Package\RootPackageInterface;
use Composer\Repository\RepositorySet;
use Composer\Repository\LockArrayRepository;
use Composer\Semver\Constraint\Constraint;
use Composer\Semver\Constraint\ConstraintInterface;
use Composer\Package\Version\VersionParser;






class Problem
{




protected $reasonSeen;





protected $reasons = array();


protected $section = 0;







public function addRule(Rule $rule)
{
$this->addReason(spl_object_hash($rule), $rule);
}






public function getReasons()
{
return $this->reasons;
}









public function getPrettyString(RepositorySet $repositorySet, Request $request, Pool $pool, $isVerbose, array $installedMap = array(), array $learnedPool = array())
{

$reasons = call_user_func_array('array_merge', array_reverse($this->reasons));

if (count($reasons) === 1) {
reset($reasons);
$rule = current($reasons);

if (!in_array($rule->getReason(), array(Rule::RULE_ROOT_REQUIRE, Rule::RULE_FIXED), true)) {
throw new \LogicException("Single reason problems must contain a request rule.");
}

$reasonData = $rule->getReasonData();
$packageName = $reasonData['packageName'];
$constraint = $reasonData['constraint'];

if (isset($constraint)) {
$packages = $pool->whatProvides($packageName, $constraint);
} else {
$packages = array();
}

if (empty($packages)) {
return "\n    ".implode(self::getMissingPackageReason($repositorySet, $request, $pool, $isVerbose, $packageName, $constraint));
}
}

return self::formatDeduplicatedRules($reasons, '    ', $repositorySet, $request, $pool, $isVerbose, $installedMap, $learnedPool);
}










public static function formatDeduplicatedRules($rules, $indent, RepositorySet $repositorySet, Request $request, Pool $pool, $isVerbose, array $installedMap = array(), array $learnedPool = array())
{
$messages = array();
$templates = array();
$parser = new VersionParser;
$deduplicatableRuleTypes = array(Rule::RULE_PACKAGE_REQUIRES, Rule::RULE_PACKAGE_CONFLICT);
foreach ($rules as $rule) {
$message = $rule->getPrettyString($repositorySet, $request, $pool, $isVerbose, $installedMap, $learnedPool);
if (in_array($rule->getReason(), $deduplicatableRuleTypes, true) && preg_match('{^(?P<package>\S+) (?P<version>\S+) (?P<type>requires|conflicts)}', $message, $m)) {
$template = preg_replace('{^\S+ \S+ }', '%s%s ', $message);
$messages[] = $template;
$templates[$template][$m[1]][$parser->normalize($m[2])] = $m[2];
} elseif ($message !== '') {
$messages[] = $message;
}
}

$result = array();
foreach (array_unique($messages) as $message) {
if (isset($templates[$message])) {
foreach ($templates[$message] as $package => $versions) {
uksort($versions, 'version_compare');
if (!$isVerbose) {
$versions = self::condenseVersionList($versions, 1);
}
if (count($versions) > 1) {

$message = preg_replace('{^(%s%s (?:require|conflict))s}', '$1', $message);
$result[] = sprintf($message, $package, '['.implode(', ', $versions).']');
} else {
$result[] = sprintf($message, $package, ' '.reset($versions));
}
}
} else {
$result[] = $message;
}
}

return "\n$indent- ".implode("\n$indent- ", $result);
}




public function isCausedByLock(RepositorySet $repositorySet, Request $request, Pool $pool)
{
foreach ($this->reasons as $sectionRules) {
foreach ($sectionRules as $rule) {
if ($rule->isCausedByLock($repositorySet, $request, $pool)) {
return true;
}
}
}

return false;
}








protected function addReason($id, Rule $reason)
{



if (!isset($this->reasonSeen[$id])) {
$this->reasonSeen[$id] = true;
$this->reasons[$this->section][] = $reason;
}
}




public function nextSection()
{
$this->section++;
}







public static function getMissingPackageReason(RepositorySet $repositorySet, Request $request, Pool $pool, $isVerbose, $packageName, ConstraintInterface $constraint = null)
{

if ($packageName === 'php' || $packageName === 'php-64bit' || $packageName === 'hhvm') {
$version = self::getPlatformPackageVersion($pool, $packageName, phpversion());

$msg = "- Root composer.json requires ".$packageName.self::constraintToText($constraint).' but ';

if (defined('HHVM_VERSION') || ($packageName === 'hhvm' && count($pool->whatProvides($packageName)) > 0)) {
return array($msg, 'your HHVM version does not satisfy that requirement.');
}

if ($packageName === 'hhvm') {
return array($msg, 'HHVM was not detected on this machine, make sure it is in your PATH.');
}

return array($msg, 'your '.$packageName.' version ('. $version .') does not satisfy that requirement.');
}


if (0 === stripos($packageName, 'ext-')) {
if (false !== strpos($packageName, ' ')) {
return array('- ', "PHP extension ".$packageName.' should be required as '.str_replace(' ', '-', $packageName).'.');
}

$ext = substr($packageName, 4);
$version = self::getPlatformPackageVersion($pool, $packageName, phpversion($ext) ?: '0');

$error = extension_loaded($ext) ? 'it has the wrong version ('.$version.') installed' : 'it is missing from your system';

return array("- Root composer.json requires PHP extension ".$packageName.self::constraintToText($constraint).' but ', $error.'. Install or enable PHP\'s '.$ext.' extension.');
}


if (0 === stripos($packageName, 'lib-')) {
if (strtolower($packageName) === 'lib-icu') {
$error = extension_loaded('intl') ? 'it has the wrong version installed, try upgrading the intl extension.' : 'it is missing from your system, make sure the intl extension is loaded.';

return array("- Root composer.json requires linked library ".$packageName.self::constraintToText($constraint).' but ', $error);
}

return array("- Root composer.json requires linked library ".$packageName.self::constraintToText($constraint).' but ', 'it has the wrong version installed or is missing from your system, make sure to load the extension providing it.');
}

$lockedPackage = null;
foreach ($request->getLockedPackages() as $package) {
if ($package->getName() === $packageName) {
$lockedPackage = $package;
if ($pool->isUnacceptableFixedOrLockedPackage($package)) {
return array("- ", $package->getPrettyName().' is fixed to '.$package->getPrettyVersion().' (lock file version) by a partial update but that version is rejected by your minimum-stability. Make sure you list it as an argument for the update command.');
}
break;
}
}



if ($packages = $repositorySet->findPackages($packageName, $constraint)) {
$rootReqs = $repositorySet->getRootRequires();
if (isset($rootReqs[$packageName])) {
$filtered = array_filter($packages, function ($p) use ($rootReqs, $packageName) {
return $rootReqs[$packageName]->matches(new Constraint('==', $p->getVersion()));
});
if (0 === count($filtered)) {
return array("- Root composer.json requires $packageName".self::constraintToText($constraint) . ', ', 'found '.self::getPackageList($packages, $isVerbose).' but '.(self::hasMultipleNames($packages) ? 'these conflict' : 'it conflicts').' with your root composer.json require ('.$rootReqs[$packageName]->getPrettyString().').');
}
}

if ($lockedPackage) {
$fixedConstraint = new Constraint('==', $lockedPackage->getVersion());
$filtered = array_filter($packages, function ($p) use ($fixedConstraint) {
return $fixedConstraint->matches(new Constraint('==', $p->getVersion()));
});
if (0 === count($filtered)) {
return array("- Root composer.json requires $packageName".self::constraintToText($constraint) . ', ', 'found '.self::getPackageList($packages, $isVerbose).' but the package is fixed to '.$lockedPackage->getPrettyVersion().' (lock file version) by a partial update and that version does not match. Make sure you list it as an argument for the update command.');
}
}

$nonLockedPackages = array_filter($packages, function ($p) {
return !$p->getRepository() instanceof LockArrayRepository;
});

if (!$nonLockedPackages) {
return array("- Root composer.json requires $packageName".self::constraintToText($constraint) . ', ', 'found '.self::getPackageList($packages, $isVerbose).' in the lock file but not in remote repositories, make sure you avoid updating this package to keep the one from the lock file.');
}

return array("- Root composer.json requires $packageName".self::constraintToText($constraint) . ', ', 'found '.self::getPackageList($packages, $isVerbose).' but these were not loaded, likely because '.(self::hasMultipleNames($packages) ? 'they conflict' : 'it conflicts').' with another require.');
}


if ($packages = $repositorySet->findPackages($packageName, $constraint, RepositorySet::ALLOW_UNACCEPTABLE_STABILITIES)) {

if ($allReposPackages = $repositorySet->findPackages($packageName, $constraint, RepositorySet::ALLOW_SHADOWED_REPOSITORIES)) {
return self::computeCheckForLowerPrioRepo($isVerbose, $packageName, $packages, $allReposPackages, 'minimum-stability', $constraint);
}

return array("- Root composer.json requires $packageName".self::constraintToText($constraint) . ', ', 'found '.self::getPackageList($packages, $isVerbose).' but '.(self::hasMultipleNames($packages) ? 'these do' : 'it does').' not match your minimum-stability.');
}


if ($packages = $repositorySet->findPackages($packageName, null, RepositorySet::ALLOW_UNACCEPTABLE_STABILITIES)) {

if ($allReposPackages = $repositorySet->findPackages($packageName, $constraint, RepositorySet::ALLOW_SHADOWED_REPOSITORIES)) {
return self::computeCheckForLowerPrioRepo($isVerbose, $packageName, $packages, $allReposPackages, 'constraint', $constraint);
}

$suffix = '';
if ($constraint instanceof Constraint && $constraint->getVersion() === 'dev-master') {
foreach ($packages as $candidate) {
if (in_array($candidate->getVersion(), array('dev-default', 'dev-main'), true)) {
$suffix = ' Perhaps dev-master was renamed to '.$candidate->getPrettyVersion().'?';
break;
}
}
}


$allReposPackages = $packages;
$topPackage = reset($allReposPackages);
if ($topPackage instanceof RootPackageInterface) {
$suffix = ' See https://getcomposer.org/dep-on-root for details and assistance.';
}

return array("- Root composer.json requires $packageName".self::constraintToText($constraint) . ', ', 'found '.self::getPackageList($packages, $isVerbose).' but '.(self::hasMultipleNames($packages) ? 'these do' : 'it does').' not match the constraint.' . $suffix);
}

if (!preg_match('{^[A-Za-z0-9_./-]+$}', $packageName)) {
$illegalChars = preg_replace('{[A-Za-z0-9_./-]+}', '', $packageName);

return array("- Root composer.json requires $packageName, it ", 'could not be found, it looks like its name is invalid, "'.$illegalChars.'" is not allowed in package names.');
}

if ($providers = $repositorySet->getProviders($packageName)) {
$maxProviders = 20;
$providersStr = implode(array_map(function ($p) {
$description = $p['description'] ? ' '.substr($p['description'], 0, 100) : '';

return "      - ${p['name']}".$description."\n";
}, count($providers) > $maxProviders + 1 ? array_slice($providers, 0, $maxProviders) : $providers));
if (count($providers) > $maxProviders + 1) {
$providersStr .= '      ... and '.(count($providers) - $maxProviders).' more.'."\n";
}

return array("- Root composer.json requires $packageName".self::constraintToText($constraint).", it ", "could not be found in any version, but the following packages provide it:\n".$providersStr."      Consider requiring one of these to satisfy the $packageName requirement.");
}

return array("- Root composer.json requires $packageName, it ", "could not be found in any version, there may be a typo in the package name.");
}







public static function getPackageList(array $packages, $isVerbose)
{
$prepared = array();
$hasDefaultBranch = array();
foreach ($packages as $package) {
$prepared[$package->getName()]['name'] = $package->getPrettyName();
$prepared[$package->getName()]['versions'][$package->getVersion()] = $package->getPrettyVersion().($package instanceof AliasPackage ? ' (alias of '.$package->getAliasOf()->getPrettyVersion().')' : '');
if ($package->isDefaultBranch()) {
$hasDefaultBranch[$package->getName()] = true;
}
}
foreach ($prepared as $name => $package) {

if (isset($package['versions'][VersionParser::DEFAULT_BRANCH_ALIAS], $hasDefaultBranch[$name])) {
unset($package['versions'][VersionParser::DEFAULT_BRANCH_ALIAS]);
}

uksort($package['versions'], 'version_compare');

if (!$isVerbose) {
$package['versions'] = self::condenseVersionList($package['versions'], 4);
}
$prepared[$name] = $package['name'].'['.implode(', ', $package['versions']).']';
}

return implode(', ', $prepared);
}






private static function getPlatformPackageVersion(Pool $pool, $packageName, $version)
{
$available = $pool->whatProvides($packageName);

if (count($available)) {
$firstAvailable = reset($available);
$version = $firstAvailable->getPrettyVersion();
$extra = $firstAvailable->getExtra();
if ($firstAvailable instanceof CompletePackageInterface && isset($extra['config.platform']) && $extra['config.platform'] === true) {
$version .= '; ' . str_replace('Package ', '', $firstAvailable->getDescription());
}
}

return $version;
}







private static function condenseVersionList(array $versions, $max, $maxDev = 16)
{
if (count($versions) <= $max) {
return $versions;
}

$filtered = array();
$byMajor = array();
foreach ($versions as $version => $pretty) {
if (0 === stripos($version, 'dev-')) {
$byMajor['dev'][] = $pretty;
} else {
$byMajor[preg_replace('{^(\d+)\..*}', '$1', $version)][] = $pretty;
}
}
foreach ($byMajor as $majorVersion => $versionsForMajor) {
$maxVersions = $majorVersion === 'dev' ? $maxDev : $max;
if (count($versionsForMajor) > $maxVersions) {

$filtered[] = $versionsForMajor[0];
$filtered[] = '...';
$filtered[] = $versionsForMajor[count($versionsForMajor) - 1];
} else {
$filtered = array_merge($filtered, $versionsForMajor);
}
}

return $filtered;
}





private static function hasMultipleNames(array $packages)
{
$name = null;
foreach ($packages as $package) {
if ($name === null || $name === $package->getName()) {
$name = $package->getName();
} else {
return true;
}
}

return false;
}









private static function computeCheckForLowerPrioRepo($isVerbose, $packageName, array $higherRepoPackages, array $allReposPackages, $reason, ConstraintInterface $constraint = null)
{
$nextRepoPackages = array();
$nextRepo = null;

foreach ($allReposPackages as $package) {
if ($nextRepo === null || $nextRepo === $package->getRepository()) {
$nextRepoPackages[] = $package;
$nextRepo = $package->getRepository();
} else {
break;
}
}

if ($higherRepoPackages) {
$topPackage = reset($higherRepoPackages);
if ($topPackage instanceof RootPackageInterface) {
return array(
"- Root composer.json requires $packageName".self::constraintToText($constraint).', it is ',
'satisfiable by '.self::getPackageList($nextRepoPackages, $isVerbose).' from '.$nextRepo->getRepoName().' but '.$topPackage->getPrettyName().' is the root package and cannot be modified. See https://getcomposer.org/dep-on-root for details and assistance.',
);
}
}

if ($nextRepo instanceof LockArrayRepository) {
$singular = count($higherRepoPackages) === 1;

return array("- Root composer.json requires $packageName".self::constraintToText($constraint) . ', it is ',
'found '.self::getPackageList($nextRepoPackages, $isVerbose).' in the lock file and '.self::getPackageList($higherRepoPackages, $isVerbose).' from '.reset($higherRepoPackages)->getRepository()->getRepoName().' but ' . ($singular ? 'it does' : 'these do') . ' not match your '.$reason.' and ' . ($singular ? 'is' : 'are') . ' therefore not installable. Make sure you either fix the '.$reason.' or avoid updating this package to keep the one from the lock file.', );
}

return array("- Root composer.json requires $packageName".self::constraintToText($constraint) . ', it is ', 'satisfiable by '.self::getPackageList($nextRepoPackages, $isVerbose).' from '.$nextRepo->getRepoName().' but '.self::getPackageList($higherRepoPackages, $isVerbose).' from '.reset($higherRepoPackages)->getRepository()->getRepoName().' has higher repository priority. The packages with higher priority do not match your '.$reason.' and are therefore not installable. See https://getcomposer.org/repoprio for details and assistance.');
}






protected static function constraintToText(ConstraintInterface $constraint = null)
{
return $constraint ? ' '.$constraint->getPrettyString() : '';
}
}
