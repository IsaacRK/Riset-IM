<?php











namespace Composer\Command;

use Composer\Composer;
use Composer\Config;
use Composer\Console\Application;
use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\IO\NullIO;
use Composer\Plugin\PreCommandRunEvent;
use Composer\Package\Version\VersionParser;
use Composer\Plugin\PluginEvents;
use Composer\Util\Platform;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Terminal;









abstract class BaseCommand extends Command
{



private $composer;




private $io;







public function getComposer($required = true, $disablePlugins = null)
{
if (null === $this->composer) {
$application = $this->getApplication();
if ($application instanceof Application) {

$this->composer = $application->getComposer($required, $disablePlugins);

} elseif ($required) {
throw new \RuntimeException(
'Could not create a Composer\Composer instance, you must inject '.
'one if this command is not used with a Composer\Console\Application instance'
);
}
}

return $this->composer;
}




public function setComposer(Composer $composer)
{
$this->composer = $composer;
}






public function resetComposer()
{
$this->composer = null;
$this->getApplication()->resetComposer();
}








public function isProxyCommand()
{
return false;
}




public function getIO()
{
if (null === $this->io) {
$application = $this->getApplication();
if ($application instanceof Application) {
$this->io = $application->getIO();

} else {
$this->io = new NullIO();
}
}

return $this->io;
}




public function setIO(IOInterface $io)
{
$this->io = $io;
}






protected function initialize(InputInterface $input, OutputInterface $output)
{

$disablePlugins = $input->hasParameterOption('--no-plugins');
$composer = $this->getComposer(false, $disablePlugins);
if (null === $composer) {
$composer = Factory::createGlobal($this->getIO(), $disablePlugins);
}
if ($composer) {
$preCommandRunEvent = new PreCommandRunEvent(PluginEvents::PRE_COMMAND_RUN, $input, $this->getName());
$composer->getEventDispatcher()->dispatch($preCommandRunEvent->getName(), $preCommandRunEvent);
}

if (true === $input->hasParameterOption(array('--no-ansi')) && $input->hasOption('no-progress')) {
$input->setOption('no-progress', true);
}

parent::initialize($input, $output);
}








protected function getPreferredInstallOptions(Config $config, InputInterface $input, $keepVcsRequiresPreferSource = false)
{
$preferSource = false;
$preferDist = false;

switch ($config->get('preferred-install')) {
case 'source':
$preferSource = true;
break;
case 'dist':
$preferDist = true;
break;
case 'auto':
default:

break;
}

if ($input->hasOption('prefer-install') && $input->getOption('prefer-install')) {
if ($input->getOption('prefer-source')) {
throw new \InvalidArgumentException('--prefer-source can not be used together with --prefer-install');
}
if ($input->getOption('prefer-dist')) {
throw new \InvalidArgumentException('--prefer-dist can not be used together with --prefer-install');
}
switch ($input->getOption('prefer-install')) {
case 'dist':
$input->setOption('prefer-dist', true);
break;
case 'source':
$input->setOption('prefer-source', true);
break;
case 'auto':
$preferDist = false;
$preferSource = false;
break;
default:
throw new \UnexpectedValueException('--prefer-install accepts one of "dist", "source" or "auto", got '.$input->getOption('prefer-install'));
}
}

if ($input->getOption('prefer-source') || $input->getOption('prefer-dist') || ($keepVcsRequiresPreferSource && $input->hasOption('keep-vcs') && $input->getOption('keep-vcs'))) {
$preferSource = $input->getOption('prefer-source') || ($keepVcsRequiresPreferSource && $input->hasOption('keep-vcs') && $input->getOption('keep-vcs'));
$preferDist = (bool) $input->getOption('prefer-dist');
}

return array($preferSource, $preferDist);
}






protected function formatRequirements(array $requirements)
{
$requires = array();
$requirements = $this->normalizeRequirements($requirements);
foreach ($requirements as $requirement) {
if (!isset($requirement['version'])) {
throw new \UnexpectedValueException('Option '.$requirement['name'] .' is missing a version constraint, use e.g. '.$requirement['name'].':^1.0');
}
$requires[$requirement['name']] = $requirement['version'];
}

return $requires;
}






protected function normalizeRequirements(array $requirements)
{
$parser = new VersionParser();

return $parser->parseNameVersionPairs($requirements);
}






protected function renderTable(array $table, OutputInterface $output)
{
$renderer = new Table($output);
$renderer->setStyle('compact');
$rendererStyle = $renderer->getStyle();
if (method_exists($rendererStyle, 'setVerticalBorderChars')) {
$rendererStyle->setVerticalBorderChars('');
} else {


$rendererStyle->setVerticalBorderChar('');
}
$rendererStyle->setCellRowContentFormat('%s  ');
$renderer->setRows($table)->render();
}




protected function getTerminalWidth()
{
if (class_exists('Symfony\Component\Console\Terminal')) {
$terminal = new Terminal();
$width = $terminal->getWidth();
} else {



list($width) = $this->getApplication()->getTerminalDimensions();
}
if (null === $width) {


$width = PHP_INT_MAX;
}
if (Platform::isWindows()) {
$width--;
} else {
$width = max(80, $width);
}

return $width;
}
}
