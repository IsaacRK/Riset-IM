<?php











namespace Composer\Util\Http;







class ProxyHelper
{







public static function getProxyData()
{
$httpProxy = null;
$httpsProxy = null;


if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
if ($env = self::getProxyEnv(array('http_proxy', 'HTTP_PROXY'), $name)) {
$httpProxy = self::checkProxy($env, $name);
}
}


if ($env = self::getProxyEnv(array('CGI_HTTP_PROXY'), $name)) {
$httpProxy = self::checkProxy($env, $name);
}


if ($env = self::getProxyEnv(array('https_proxy', 'HTTPS_PROXY'), $name)) {
$httpsProxy = self::checkProxy($env, $name);
} else {
$httpsProxy = $httpProxy;
}


$noProxy = self::getProxyEnv(array('no_proxy', 'NO_PROXY'), $name);

return array($httpProxy, $httpsProxy, $noProxy);
}








public static function getContextOptions($proxyUrl)
{
$proxy = parse_url($proxyUrl);


$proxyUrl = self::formatParsedUrl($proxy, false);
$proxyUrl = str_replace(array('http://', 'https://'), array('tcp://', 'ssl://'), $proxyUrl);

$options['http']['proxy'] = $proxyUrl;


if (isset($proxy['user'])) {
$auth = rawurldecode($proxy['user']);

if (isset($proxy['pass'])) {
$auth .= ':' . rawurldecode($proxy['pass']);
}
$auth = base64_encode($auth);

$options['http']['header'] = "Proxy-Authorization: Basic {$auth}";
}

return $options;
}









public static function setRequestFullUri($requestUrl, array &$options)
{
if ('http' === parse_url($requestUrl, PHP_URL_SCHEME)) {
$options['http']['request_fulluri'] = true;
} else {
unset($options['http']['request_fulluri']);
}
}









private static function getProxyEnv(array $names, &$name)
{
foreach ($names as $name) {
if (!empty($_SERVER[$name])) {
return $_SERVER[$name];
}
}

return null;
}









private static function checkProxy($proxyUrl, $envName)
{
$error = sprintf('malformed %s url', $envName);
$proxy = parse_url($proxyUrl);


if (!isset($proxy['host'])) {
throw new \RuntimeException($error);
}

$proxyUrl = self::formatParsedUrl($proxy, true);


if (!parse_url($proxyUrl, PHP_URL_PORT)) {
throw new \RuntimeException($error);
}

return $proxyUrl;
}









private static function formatParsedUrl(array $proxy, $includeAuth)
{
$proxyUrl = isset($proxy['scheme']) ? strtolower($proxy['scheme']) . '://' : '';

if ($includeAuth && isset($proxy['user'])) {
$proxyUrl .= $proxy['user'];

if (isset($proxy['pass'])) {
$proxyUrl .= ':' . $proxy['pass'];
}
$proxyUrl .= '@';
}

$proxyUrl .= $proxy['host'];

if (isset($proxy['port'])) {
$proxyUrl .= ':' . $proxy['port'];
} elseif (strpos($proxyUrl, 'http://') === 0) {
$proxyUrl .= ':80';
} elseif (strpos($proxyUrl, 'https://') === 0) {
$proxyUrl .= ':443';
}

return $proxyUrl;
}
}
