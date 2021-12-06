<?php











namespace Composer\Util;






class Platform
{

private static $isVirtualBoxGuest = null;

private static $isWindowsSubsystemForLinux = null;








public static function putEnv($name, $value)
{
$value = (string) $value;
putenv($name . '=' . $value);
$_SERVER[$name] = $_ENV[$name] = $value;
}







public static function clearEnv($name)
{
putenv($name);
unset($_SERVER[$name], $_ENV[$name]);
}







public static function expandPath($path)
{
if (preg_match('#^~[\\/]#', $path)) {
return self::getUserDirectory() . substr($path, 1);
}

return preg_replace_callback('#^(\$|(?P<percent>%))(?P<var>\w++)(?(percent)%)(?P<path>.*)#', function ($matches) {

if (Platform::isWindows() && $matches['var'] == 'HOME') {
return (getenv('HOME') ?: getenv('USERPROFILE')) . $matches['path'];
}

return getenv($matches['var']) . $matches['path'];
}, $path);
}





public static function getUserDirectory()
{
if (false !== ($home = getenv('HOME'))) {
return $home;
}

if (self::isWindows() && false !== ($home = getenv('USERPROFILE'))) {
return $home;
}

if (\function_exists('posix_getuid') && \function_exists('posix_getpwuid')) {
$info = posix_getpwuid(posix_getuid());

return $info['dir'];
}

throw new \RuntimeException('Could not determine user directory');
}




public static function isWindowsSubsystemForLinux()
{
if (null === self::$isWindowsSubsystemForLinux) {
self::$isWindowsSubsystemForLinux = false;


if (self::isWindows()) {
return self::$isWindowsSubsystemForLinux = false;
}

if (
!ini_get('open_basedir')
&& is_readable('/proc/version')
&& false !== stripos(Silencer::call('file_get_contents', '/proc/version'), 'microsoft')
&& !file_exists('/.dockerenv') 
) {
return self::$isWindowsSubsystemForLinux = true;
}
}

return self::$isWindowsSubsystemForLinux;
}




public static function isWindows()
{
return \defined('PHP_WINDOWS_VERSION_BUILD');
}





public static function strlen($str)
{
static $useMbString = null;
if (null === $useMbString) {
$useMbString = \function_exists('mb_strlen') && ini_get('mbstring.func_overload');
}

if ($useMbString) {
return mb_strlen($str, '8bit');
}

return \strlen($str);
}





public static function isTty($fd = null)
{
if ($fd === null) {
$fd = defined('STDOUT') ? STDOUT : fopen('php://stdout', 'w');
}



if (in_array(strtoupper(getenv('MSYSTEM') ?: ''), array('MINGW32', 'MINGW64'), true)) {
return true;
}



if (function_exists('stream_isatty')) {
return stream_isatty($fd);
}


if (function_exists('posix_isatty') && posix_isatty($fd)) {
return true;
}

$stat = @fstat($fd);

return $stat ? 0020000 === ($stat['mode'] & 0170000) : false;
}




public static function workaroundFilesystemIssues()
{
if (self::isVirtualBoxGuest()) {
usleep(200000);
}
}








private static function isVirtualBoxGuest()
{
if (null === self::$isVirtualBoxGuest) {
self::$isVirtualBoxGuest = false;
if (self::isWindows()) {
return self::$isVirtualBoxGuest;
}

if (function_exists('posix_getpwuid') && function_exists('posix_geteuid')) {
$processUser = posix_getpwuid(posix_geteuid());
if ($processUser && $processUser['name'] === 'vagrant') {
return self::$isVirtualBoxGuest = true;
}
}

if (getenv('COMPOSER_RUNTIME_ENV') === 'virtualbox') {
return self::$isVirtualBoxGuest = true;
}

if (defined('PHP_OS_FAMILY') && PHP_OS_FAMILY === 'Linux') {
$process = new ProcessExecutor();
try {
if (0 === $process->execute('lsmod | grep vboxguest', $ignoredOutput)) {
return self::$isVirtualBoxGuest = true;
}
} catch (\Exception $e) {

}
}
}

return self::$isVirtualBoxGuest;
}
}
