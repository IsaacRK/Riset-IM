<?php











namespace Composer\Plugin;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Package\CompletePackage;
use Composer\Package\Package;
use Composer\Package\Version\VersionParser;
use Composer\Repository\RepositoryInterface;
use Composer\Repository\InstalledRepository;
use Composer\Repository\RootPackageRepository;
use Composer\Package\PackageInterface;
use Composer\Package\Link;
use Composer\Semver\Constraint\Constraint;
use Composer\Plugin\Capability\Capability;
use Composer\Util\PackageSorter;







class PluginManager
{

protected $composer;

protected $io;

protected $globalComposer;

protected $versionParser;

protected $disablePlugins = false;


protected $plugins = array();

protected $registeredPlugins = array();


private static $classCounter = 0;









public function __construct(IOInterface $io, Composer $composer, Composer $globalComposer = null, $disablePlugins = false)
{
$this->io = $io;
$this->composer = $composer;
$this->globalComposer = $globalComposer;
$this->versionParser = new VersionParser();
$this->disablePlugins = $disablePlugins;
}






public function loadInstalledPlugins()
{
if ($this->disablePlugins) {
return;
}

$repo = $this->composer->getRepositoryManager()->getLocalRepository();
$globalRepo = $this->globalComposer ? $this->globalComposer->getRepositoryManager()->getLocalRepository() : null;
$this->loadRepository($repo, false);
if ($globalRepo) {
$this->loadRepository($globalRepo, true);
}
}






public function getPlugins()
{
return $this->plugins;
}






public function getGlobalComposer()
{
return $this->globalComposer;
}















public function registerPackage(PackageInterface $package, $failOnMissingClasses = false, $isGlobalPlugin = false)
{
if ($this->disablePlugins) {
return;
}

if ($package->getType() === 'composer-plugin') {
$requiresComposer = null;
foreach ($package->getRequires() as $link) { 
if ('composer-plugin-api' === $link->getTarget()) {
$requiresComposer = $link->getConstraint();
break;
}
}

if (!$requiresComposer) {
throw new \RuntimeException("Plugin ".$package->getName()." is missing a require statement for a version of the composer-plugin-api package.");
}

$currentPluginApiVersion = $this->getPluginApiVersion();
$currentPluginApiConstraint = new Constraint('==', $this->versionParser->normalize($currentPluginApiVersion));

if ($requiresComposer->getPrettyString() === $this->getPluginApiVersion()) {
$this->io->writeError('<warning>The "' . $package->getName() . '" plugin requires composer-plugin-api '.$this->getPluginApiVersion().', this *WILL* break in the future and it should be fixed ASAP (require ^'.$this->getPluginApiVersion().' instead for example).</warning>');
} elseif (!$requiresComposer->matches($currentPluginApiConstraint)) {
$this->io->writeError('<warning>The "' . $package->getName() . '" plugin '.($isGlobalPlugin ? '(installed globally) ' : '').'was skipped because it requires a Plugin API version ("' . $requiresComposer->getPrettyString() . '") that does not match your Composer installation ("' . $currentPluginApiVersion . '"). You may need to run composer update with the "--no-plugins" option.</warning>');

return;
}

if ($package->getName() === 'symfony/flex' && preg_match('{^[0-9.]+$}', $package->getVersion()) && version_compare($package->getVersion(), '1.9.8', '<')) {
$this->io->writeError('<warning>The "' . $package->getName() . '" plugin '.($isGlobalPlugin ? '(installed globally) ' : '').'was skipped because it is not compatible with Composer 2+. Make sure to update it to version 1.9.8 or greater.</warning>');

return;
}
}

$oldInstallerPlugin = ($package->getType() === 'composer-installer');

if (isset($this->registeredPlugins[$package->getName()])) {
return;
}

$extra = $package->getExtra();
if (empty($extra['class'])) {
throw new \UnexpectedValueException('Error while installing '.$package->getPrettyName().', composer-plugin packages should have a class defined in their extra key to be usable.');
}
$classes = is_array($extra['class']) ? $extra['class'] : array($extra['class']);

$localRepo = $this->composer->getRepositoryManager()->getLocalRepository();
$globalRepo = $this->globalComposer ? $this->globalComposer->getRepositoryManager()->getLocalRepository() : null;

$rootPackage = clone $this->composer->getPackage();
$rootPackageRepo = new RootPackageRepository($rootPackage);
$installedRepo = new InstalledRepository(array($localRepo, $rootPackageRepo));
if ($globalRepo) {
$installedRepo->addRepository($globalRepo);
}

$autoloadPackages = array($package->getName() => $package);
$autoloadPackages = $this->collectDependencies($installedRepo, $autoloadPackages, $package);

$generator = $this->composer->getAutoloadGenerator();
$autoloads = array(array($rootPackage, ''));
foreach ($autoloadPackages as $autoloadPackage) {
if ($autoloadPackage === $rootPackage) {
continue;
}

$downloadPath = $this->getInstallPath($autoloadPackage, $globalRepo && $globalRepo->hasPackage($autoloadPackage));
$autoloads[] = array($autoloadPackage, $downloadPath);
}

$map = $generator->parseAutoloads($autoloads, $rootPackage);
$classLoader = $generator->createLoader($map, $this->composer->getConfig()->get('vendor-dir'));
$classLoader->register(false);

foreach ($classes as $class) {
if (class_exists($class, false)) {
$class = trim($class, '\\');
$path = $classLoader->findFile($class);
$code = file_get_contents($path);
$separatorPos = strrpos($class, '\\');
$className = $class;
if ($separatorPos) {
$className = substr($class, $separatorPos + 1);
}
$code = preg_replace('{^((?:final\s+)?(?:\s*))class\s+('.preg_quote($className).')}mi', '$1class $2_composer_tmp'.self::$classCounter, $code, 1);
$code = strtr($code, array(
'__FILE__' => var_export($path, true),
'__DIR__' => var_export(dirname($path), true),
'__CLASS__' => var_export($class, true),
));
$code = preg_replace('/^\s*<\?(php)?/i', '', $code, 1);
eval($code);
$class .= '_composer_tmp'.self::$classCounter;
self::$classCounter++;
}

if ($oldInstallerPlugin) {
$this->io->writeError('<warning>Loading "'.$package->getName() . '" '.($isGlobalPlugin ? '(installed globally) ' : '').'which is a legacy composer-installer built for Composer 1.x, it is likely to cause issues as you are running Composer 2.x.</warning>');
$installer = new $class($this->io, $this->composer);
$this->composer->getInstallationManager()->addInstaller($installer);
$this->registeredPlugins[$package->getName()] = $installer;
} elseif (class_exists($class)) {
$plugin = new $class();
$this->addPlugin($plugin, $isGlobalPlugin, $package);
$this->registeredPlugins[$package->getName()] = $plugin;
} elseif ($failOnMissingClasses) {
throw new \UnexpectedValueException('Plugin '.$package->getName().' could not be initialized, class not found: '.$class);
}
}
}













public function deactivatePackage(PackageInterface $package)
{
if ($this->disablePlugins) {
return;
}

$oldInstallerPlugin = ($package->getType() === 'composer-installer');

if (!isset($this->registeredPlugins[$package->getName()])) {
return;
}

if ($oldInstallerPlugin) {

$installer = $this->registeredPlugins[$package->getName()];
unset($this->registeredPlugins[$package->getName()]);
$this->composer->getInstallationManager()->removeInstaller($installer);
} else {
$plugin = $this->registeredPlugins[$package->getName()];
unset($this->registeredPlugins[$package->getName()]);
$this->removePlugin($plugin);
}
}













public function uninstallPackage(PackageInterface $package)
{
if ($this->disablePlugins) {
return;
}

$oldInstallerPlugin = ($package->getType() === 'composer-installer');

if (!isset($this->registeredPlugins[$package->getName()])) {
return;
}

if ($oldInstallerPlugin) {
$this->deactivatePackage($package);
} else {
$plugin = $this->registeredPlugins[$package->getName()];
unset($this->registeredPlugins[$package->getName()]);
$this->removePlugin($plugin);
$this->uninstallPlugin($plugin);
}
}






protected function getPluginApiVersion()
{
return PluginInterface::PLUGIN_API_VERSION;
}














public function addPlugin(PluginInterface $plugin, $isGlobalPlugin = false, PackageInterface $sourcePackage = null)
{
$details = array();
if ($sourcePackage) {
$details[] = 'from '.$sourcePackage->getName();
}
if ($isGlobalPlugin) {
$details[] = 'installed globally';
}
$this->io->writeError('Loading plugin '.get_class($plugin).($details ? ' ('.implode(', ', $details).')' : ''), true, IOInterface::DEBUG);
$this->plugins[] = $plugin;
$plugin->activate($this->composer, $this->io);

if ($plugin instanceof EventSubscriberInterface) {
$this->composer->getEventDispatcher()->addSubscriber($plugin);
}
}












public function removePlugin(PluginInterface $plugin)
{
$index = array_search($plugin, $this->plugins, true);
if ($index === false) {
return;
}

$this->io->writeError('Unloading plugin '.get_class($plugin), true, IOInterface::DEBUG);
unset($this->plugins[$index]);
$plugin->deactivate($this->composer, $this->io);

$this->composer->getEventDispatcher()->removeListener($plugin);
}












public function uninstallPlugin(PluginInterface $plugin)
{
$this->io->writeError('Uninstalling plugin '.get_class($plugin), true, IOInterface::DEBUG);
$plugin->uninstall($this->composer, $this->io);
}

















private function loadRepository(RepositoryInterface $repo, $isGlobalRepo)
{
$packages = $repo->getPackages();
$sortedPackages = PackageSorter::sortPackages($packages);
foreach ($sortedPackages as $package) {
if (!($package instanceof CompletePackage)) {
continue;
}
if ('composer-plugin' === $package->getType()) {
$this->registerPackage($package, false, $isGlobalRepo);

} elseif ('composer-installer' === $package->getType()) {
$this->registerPackage($package, false, $isGlobalRepo);
}
}
}










private function collectDependencies(InstalledRepository $installedRepo, array $collected, PackageInterface $package)
{
foreach ($package->getRequires() as $requireLink) {
foreach ($installedRepo->findPackagesWithReplacersAndProviders($requireLink->getTarget()) as $requiredPackage) {
if (!isset($collected[$requiredPackage->getName()])) {
$collected[$requiredPackage->getName()] = $requiredPackage;
$collected = $this->collectDependencies($installedRepo, $collected, $requiredPackage);
}
}
}

return $collected;
}









private function getInstallPath(PackageInterface $package, $global = false)
{
if (!$global) {
return $this->composer->getInstallationManager()->getInstallPath($package);
}

return $this->globalComposer->getInstallationManager()->getInstallPath($package);
}







protected function getCapabilityImplementationClassName(PluginInterface $plugin, $capability)
{
if (!($plugin instanceof Capable)) {
return null;
}

$capabilities = (array) $plugin->getCapabilities();

if (!empty($capabilities[$capability]) && is_string($capabilities[$capability]) && trim($capabilities[$capability])) {
return trim($capabilities[$capability]);
}

if (
array_key_exists($capability, $capabilities)
&& (empty($capabilities[$capability]) || !is_string($capabilities[$capability]) || !trim($capabilities[$capability]))
) {
throw new \UnexpectedValueException('Plugin '.get_class($plugin).' provided invalid capability class name(s), got '.var_export($capabilities[$capability], true));
}

return null;
}












public function getPluginCapability(PluginInterface $plugin, $capabilityClassName, array $ctorArgs = array())
{
if ($capabilityClass = $this->getCapabilityImplementationClassName($plugin, $capabilityClassName)) {
if (!class_exists($capabilityClass)) {
throw new \RuntimeException("Cannot instantiate Capability, as class $capabilityClass from plugin ".get_class($plugin)." does not exist.");
}

$ctorArgs['plugin'] = $plugin;
$capabilityObj = new $capabilityClass($ctorArgs);


if (!$capabilityObj instanceof Capability || !$capabilityObj instanceof $capabilityClassName) {
throw new \RuntimeException(
'Class ' . $capabilityClass . ' must implement both Composer\Plugin\Capability\Capability and '. $capabilityClassName . '.'
);
}

return $capabilityObj;
}

return null;
}









public function getPluginCapabilities($capabilityClassName, array $ctorArgs = array())
{
$capabilities = array();
foreach ($this->getPlugins() as $plugin) {
if ($capability = $this->getPluginCapability($plugin, $capabilityClassName, $ctorArgs)) {
$capabilities[] = $capability;
}
}

return $capabilities;
}
}
