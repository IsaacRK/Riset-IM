<?php










namespace Composer\XdebugHandler;






class Process
{












public static function escape($arg, $meta = true, $module = false)
{
if (!defined('PHP_WINDOWS_VERSION_BUILD')) {
return "'".str_replace("'", "'\\''", $arg)."'";
}

$quote = strpbrk($arg, " \t") !== false || $arg === '';

$arg = preg_replace('/(\\\\*)"/', '$1$1\\"', $arg, -1, $dquotes);

if ($meta) {
$meta = $dquotes || preg_match('/%[^%]+%/', $arg);

if (!$meta) {
$quote = $quote || strpbrk($arg, '^&|<>()') !== false;
} elseif ($module && !$dquotes && $quote) {
$meta = false;
}
}

if ($quote) {
$arg = '"'.preg_replace('/(\\\\*)$/', '$1$1', $arg).'"';
}

if ($meta) {
$arg = preg_replace('/(["^&|<>()%])/', '^$1', $arg);
}

return $arg;
}








public static function escapeShellCommand(array $args)
{
$cmd = self::escape(array_shift($args), true, true);
foreach ($args as $arg) {
$cmd .= ' '.self::escape($arg);
}

return $cmd;
}









public static function setEnv($name, $value = null)
{
$unset = null === $value;

if (!putenv($unset ? $name : $name.'='.$value)) {
return false;
}

if ($unset) {
unset($_SERVER[$name]);
} else {
$_SERVER[$name] = $value;
}


if (false !== stripos((string) ini_get('variables_order'), 'E')) {
if ($unset) {
unset($_ENV[$name]);
} else {
$_ENV[$name] = $value;
}
}

return true;
}
}
