<?php











namespace Composer;

use Composer\Config\ConfigSourceInterface;
use Composer\Downloader\TransportException;
use Composer\IO\IOInterface;
use Composer\Util\Platform;
use Composer\Util\ProcessExecutor;




class Config
{
const RELATIVE_PATHS = 1;


public static $defaultConfig = array(
'process-timeout' => 300,
'use-include-path' => false,
'preferred-install' => 'dist',
'notify-on-install' => true,
'github-protocols' => array('https', 'ssh', 'git'),
'gitlab-protocol' => null,
'vendor-dir' => 'vendor',
'bin-dir' => '{$vendor-dir}/bin',
'cache-dir' => '{$home}/cache',
'data-dir' => '{$home}',
'cache-files-dir' => '{$cache-dir}/files',
'cache-repo-dir' => '{$cache-dir}/repo',
'cache-vcs-dir' => '{$cache-dir}/vcs',
'cache-ttl' => 15552000, 
'cache-files-ttl' => null, 
'cache-files-maxsize' => '300MiB',
'cache-read-only' => false,
'bin-compat' => 'auto',
'discard-changes' => false,
'autoloader-suffix' => null,
'sort-packages' => false,
'optimize-autoloader' => false,
'classmap-authoritative' => false,
'apcu-autoloader' => false,
'prepend-autoloader' => true,
'github-domains' => array('github.com'),
'bitbucket-expose-hostname' => true,
'disable-tls' => false,
'secure-http' => true,
'secure-svn-domains' => array(),
'cafile' => null,
'capath' => null,
'github-expose-hostname' => true,
'gitlab-domains' => array('gitlab.com'),
'store-auths' => 'prompt',
'platform' => array(),
'archive-format' => 'tar',
'archive-dir' => '.',
'htaccess-protect' => true,
'use-github-api' => true,
'lock' => true,
'platform-check' => 'php-only',







);


public static $defaultRepositories = array(
'packagist.org' => array(
'type' => 'composer',
'url' => 'https://repo.packagist.org',
),
);


private $config;

private $baseDir;

private $repositories;

private $configSource;

private $authConfigSource;

private $useEnvironment;

private $warnedHosts = array();





public function __construct($useEnvironment = true, $baseDir = null)
{

$this->config = static::$defaultConfig;
$this->repositories = static::$defaultRepositories;
$this->useEnvironment = (bool) $useEnvironment;
$this->baseDir = $baseDir;
}




public function setConfigSource(ConfigSourceInterface $source)
{
$this->configSource = $source;
}




public function getConfigSource()
{
return $this->configSource;
}




public function setAuthConfigSource(ConfigSourceInterface $source)
{
$this->authConfigSource = $source;
}




public function getAuthConfigSource()
{
return $this->authConfigSource;
}








public function merge($config)
{

if (!empty($config['config']) && is_array($config['config'])) {
foreach ($config['config'] as $key => $val) {
if (in_array($key, array('bitbucket-oauth', 'github-oauth', 'gitlab-oauth', 'gitlab-token', 'http-basic', 'bearer')) && isset($this->config[$key])) {
$this->config[$key] = array_merge($this->config[$key], $val);
} elseif (in_array($key, array('gitlab-domains', 'github-domains')) && isset($this->config[$key])) {
$this->config[$key] = array_unique(array_merge($this->config[$key], $val));
} elseif ('preferred-install' === $key && isset($this->config[$key])) {
if (is_array($val) || is_array($this->config[$key])) {
if (is_string($val)) {
$val = array('*' => $val);
}
if (is_string($this->config[$key])) {
$this->config[$key] = array('*' => $this->config[$key]);
}
$this->config[$key] = array_merge($this->config[$key], $val);

if (isset($this->config[$key]['*'])) {
$wildcard = $this->config[$key]['*'];
unset($this->config[$key]['*']);
$this->config[$key]['*'] = $wildcard;
}
} else {
$this->config[$key] = $val;
}
} else {
$this->config[$key] = $val;
}
}
}

if (!empty($config['repositories']) && is_array($config['repositories'])) {
$this->repositories = array_reverse($this->repositories, true);
$newRepos = array_reverse($config['repositories'], true);
foreach ($newRepos as $name => $repository) {

if (false === $repository) {
$this->disableRepoByName((string) $name);
continue;
}


if (is_array($repository) && 1 === count($repository) && false === current($repository)) {
$this->disableRepoByName((string) key($repository));
continue;
}


if (isset($repository['type'], $repository['url']) && $repository['type'] === 'composer' && preg_match('{^https?://(?:[a-z0-9-.]+\.)?packagist.org(/|$)}', $repository['url'])) {
$this->disableRepoByName('packagist.org');
}


if (is_int($name)) {
$this->repositories[] = $repository;
} else {
if ($name === 'packagist') { 
$this->repositories[$name . '.org'] = $repository;
} else {
$this->repositories[$name] = $repository;
}
}
}
$this->repositories = array_reverse($this->repositories, true);
}
}




public function getRepositories()
{
return $this->repositories;
}










public function get($key, $flags = 0)
{
switch ($key) {

case 'vendor-dir':
case 'bin-dir':
case 'process-timeout':
case 'data-dir':
case 'cache-dir':
case 'cache-files-dir':
case 'cache-repo-dir':
case 'cache-vcs-dir':
case 'cafile':
case 'capath':

$env = 'COMPOSER_' . strtoupper(strtr($key, '-', '_'));

$val = $this->getComposerEnv($env);
$val = rtrim((string) $this->process(false !== $val ? $val : $this->config[$key], $flags), '/\\');
$val = Platform::expandPath($val);

if (substr($key, -4) !== '-dir') {
return $val;
}

return (($flags & self::RELATIVE_PATHS) == self::RELATIVE_PATHS) ? $val : $this->realpath($val);


case 'cache-read-only':
case 'htaccess-protect':

$env = 'COMPOSER_' . strtoupper(strtr($key, '-', '_'));

$val = $this->getComposerEnv($env);
if (false === $val) {
$val = $this->config[$key];
}

return $val !== 'false' && (bool) $val;


case 'disable-tls':
case 'secure-http':
case 'use-github-api':
case 'lock':

if ($key === 'secure-http' && $this->get('disable-tls') === true) {
return false;
}

return $this->config[$key] !== 'false' && (bool) $this->config[$key];


case 'cache-ttl':
return (int) $this->config[$key];


case 'cache-files-maxsize':
if (!preg_match('/^\s*([0-9.]+)\s*(?:([kmg])(?:i?b)?)?\s*$/i', $this->config[$key], $matches)) {
throw new \RuntimeException(
"Could not parse the value of '$key': {$this->config[$key]}"
);
}
$size = $matches[1];
if (isset($matches[2])) {
switch (strtolower($matches[2])) {
case 'g':
$size *= 1024;


case 'm':
$size *= 1024;


case 'k':
$size *= 1024;
break;
}
}

return $size;


case 'cache-files-ttl':
if (isset($this->config[$key])) {
return (int) $this->config[$key];
}

return (int) $this->config['cache-ttl'];

case 'home':
$val = preg_replace('#^(\$HOME|~)(/|$)#', rtrim(getenv('HOME') ?: getenv('USERPROFILE'), '/\\') . '/', $this->config[$key]);

return rtrim($this->process($val, $flags), '/\\');

case 'bin-compat':
$value = $this->getComposerEnv('COMPOSER_BIN_COMPAT') ?: $this->config[$key];

if (!in_array($value, array('auto', 'full', 'symlink'))) {
throw new \RuntimeException(
"Invalid value for 'bin-compat': {$value}. Expected auto, full or symlink"
);
}

return $value;

case 'discard-changes':
if ($env = $this->getComposerEnv('COMPOSER_DISCARD_CHANGES')) {
if (!in_array($env, array('stash', 'true', 'false', '1', '0'), true)) {
throw new \RuntimeException(
"Invalid value for COMPOSER_DISCARD_CHANGES: {$env}. Expected 1, 0, true, false or stash"
);
}
if ('stash' === $env) {
return 'stash';
}


return $env !== 'false' && (bool) $env;
}

if (!in_array($this->config[$key], array(true, false, 'stash'), true)) {
throw new \RuntimeException(
"Invalid value for 'discard-changes': {$this->config[$key]}. Expected true, false or stash"
);
}

return $this->config[$key];

case 'github-protocols':
$protos = $this->config['github-protocols'];
if ($this->config['secure-http'] && false !== ($index = array_search('git', $protos))) {
unset($protos[$index]);
}
if (reset($protos) === 'http') {
throw new \RuntimeException('The http protocol for github is not available anymore, update your config\'s github-protocols to use "https", "git" or "ssh"');
}

return $protos;

default:
if (!isset($this->config[$key])) {
return null;
}

return $this->process($this->config[$key], $flags);
}
}






public function all($flags = 0)
{
$all = array(
'repositories' => $this->getRepositories(),
);
foreach (array_keys($this->config) as $key) {
$all['config'][$key] = $this->get($key, $flags);
}

return $all;
}




public function raw()
{
return array(
'repositories' => $this->getRepositories(),
'config' => $this->config,
);
}







public function has($key)
{
return array_key_exists($key, $this->config);
}









private function process($value, $flags)
{
$config = $this;

if (!is_string($value)) {
return $value;
}

return preg_replace_callback('#\{\$(.+)\}#', function ($match) use ($config, $flags) {
return $config->get($match[1], $flags);
}, $value);
}









private function realpath($path)
{
if (preg_match('{^(?:/|[a-z]:|[a-z0-9.]+://)}i', $path)) {
return $path;
}

return $this->baseDir . '/' . $path;
}










private function getComposerEnv($var)
{
if ($this->useEnvironment) {
return getenv($var);
}

return false;
}






private function disableRepoByName($name)
{
if (isset($this->repositories[$name])) {
unset($this->repositories[$name]);
} elseif ($name === 'packagist') { 
unset($this->repositories['packagist.org']);
}
}









public function prohibitUrlByConfig($url, IOInterface $io = null)
{

if (false === filter_var($url, FILTER_VALIDATE_URL)) {
return;
}


$scheme = parse_url($url, PHP_URL_SCHEME);
$hostname = parse_url($url, PHP_URL_HOST);
if (in_array($scheme, array('http', 'git', 'ftp', 'svn'))) {
if ($this->get('secure-http')) {
if ($scheme === 'svn') {
if (in_array($hostname, $this->get('secure-svn-domains'), true)) {
return;
}

throw new TransportException("Your configuration does not allow connections to $url. See https://getcomposer.org/doc/06-config.md#secure-svn-domains for details.");
}

throw new TransportException("Your configuration does not allow connections to $url. See https://getcomposer.org/doc/06-config.md#secure-http for details.");
}
if ($io) {
$host = parse_url($url, PHP_URL_HOST);
if (!isset($this->warnedHosts[$host])) {
$io->writeError("<warning>Warning: Accessing $host over $scheme which is an insecure protocol.</warning>");
}
$this->warnedHosts[$host] = true;
}
}
}













public static function disableProcessTimeout()
{

ProcessExecutor::setTimeout(0);
}
}
