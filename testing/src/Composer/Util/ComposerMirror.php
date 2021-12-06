<?php











namespace Composer\Util;






class ComposerMirror
{










public static function processUrl($mirrorUrl, $packageName, $version, $reference, $type, $prettyVersion = null)
{
if ($reference) {
$reference = preg_match('{^([a-f0-9]*|%reference%)$}', $reference) ? $reference : md5($reference);
}
$version = strpos($version, '/') === false ? $version : md5($version);

$from = array('%package%', '%version%', '%reference%', '%type%');
$to = array($packageName, $version, $reference, $type);
if (null !== $prettyVersion) {
$from[] = '%prettyVersion%';
$to[] = $prettyVersion;
}

return str_replace($from, $to, $mirrorUrl);
}









public static function processGitUrl($mirrorUrl, $packageName, $url, $type)
{
if (preg_match('#^(?:(?:https?|git)://github\.com/|git@github\.com:)([^/]+)/(.+?)(?:\.git)?$#', $url, $match)) {
$url = 'gh-'.$match[1].'/'.$match[2];
} elseif (preg_match('#^https://bitbucket\.org/([^/]+)/(.+?)(?:\.git)?/?$#', $url, $match)) {
$url = 'bb-'.$match[1].'/'.$match[2];
} else {
$url = preg_replace('{[^a-z0-9_.-]}i', '-', trim($url, '/'));
}

return str_replace(
array('%package%', '%normalizedUrl%', '%type%'),
array($packageName, $url, $type),
$mirrorUrl
);
}









public static function processHgUrl($mirrorUrl, $packageName, $url, $type)
{
return self::processGitUrl($mirrorUrl, $packageName, $url, $type);
}
}
