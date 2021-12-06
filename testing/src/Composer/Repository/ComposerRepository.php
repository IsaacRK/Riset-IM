<?php











namespace Composer\Repository;

use Composer\Package\BasePackage;
use Composer\Package\Loader\ArrayLoader;
use Composer\Package\PackageInterface;
use Composer\Package\AliasPackage;
use Composer\Package\CompletePackage;
use Composer\Package\CompleteAliasPackage;
use Composer\Package\Version\VersionParser;
use Composer\Package\Version\StabilityFilter;
use Composer\Json\JsonFile;
use Composer\Cache;
use Composer\Config;
use Composer\IO\IOInterface;
use Composer\Plugin\PostFileDownloadEvent;
use Composer\Semver\CompilingMatcher;
use Composer\Util\HttpDownloader;
use Composer\Util\Loop;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PreFileDownloadEvent;
use Composer\EventDispatcher\EventDispatcher;
use Composer\Downloader\TransportException;
use Composer\Semver\Constraint\ConstraintInterface;
use Composer\Semver\Constraint\Constraint;
use Composer\Semver\Constraint\MatchAllConstraint;
use Composer\Util\Http\Response;
use Composer\MetadataMinifier\MetadataMinifier;
use Composer\Util\Url;




class ComposerRepository extends ArrayRepository implements ConfigurableRepositoryInterface
{




private $repoConfig;

private $options;

private $url;

private $baseUrl;

private $io;

private $httpDownloader;

private $loop;

protected $cache;

protected $notifyUrl = null;

protected $searchUrl = null;

protected $providersApiUrl = null;

protected $hasProviders = false;

protected $providersUrl = null;

protected $listUrl = null;

protected $hasAvailablePackageList = false;

protected $availablePackages = null;

protected $availablePackagePatterns = null;

protected $lazyProvidersUrl = null;

protected $providerListing;

protected $loader;

private $allowSslDowngrade = false;

private $eventDispatcher;

private $sourceMirrors;

private $distMirrors;

private $degradedMode = false;

private $rootData;

private $hasPartialPackages = false;

private $partialPackagesByName = null;








public $freshMetadataUrls = array();








public $packagesNotFoundCache = array();





public $versionParser;





public function __construct(array $repoConfig, IOInterface $io, Config $config, HttpDownloader $httpDownloader, EventDispatcher $eventDispatcher = null)
{
parent::__construct();
if (!preg_match('{^[\w.]+\??://}', $repoConfig['url'])) {

$repoConfig['url'] = 'http://'.$repoConfig['url'];
}
$repoConfig['url'] = rtrim($repoConfig['url'], '/');

if (strpos($repoConfig['url'], 'https?') === 0) {
$repoConfig['url'] = (extension_loaded('openssl') ? 'https' : 'http') . substr($repoConfig['url'], 6);
}

$urlBits = parse_url($repoConfig['url']);
if ($urlBits === false || empty($urlBits['scheme'])) {
throw new \UnexpectedValueException('Invalid url given for Composer repository: '.$repoConfig['url']);
}

if (!isset($repoConfig['options'])) {
$repoConfig['options'] = array();
}
if (isset($repoConfig['allow_ssl_downgrade']) && true === $repoConfig['allow_ssl_downgrade']) {
$this->allowSslDowngrade = true;
}

$this->options = $repoConfig['options'];
$this->url = $repoConfig['url'];


if (preg_match('{^(?P<proto>https?)://packagist\.org/?$}i', $this->url, $match)) {
$this->url = $match['proto'].'://repo.packagist.org';
}

$this->baseUrl = rtrim(preg_replace('{(?:/[^/\\\\]+\.json)?(?:[?#].*)?$}', '', $this->url), '/');
$this->io = $io;
$this->cache = new Cache($io, $config->get('cache-repo-dir').'/'.preg_replace('{[^a-z0-9.]}i', '-', Url::sanitize($this->url)), 'a-z0-9.$~');
$this->cache->setReadOnly($config->get('cache-read-only'));
$this->versionParser = new VersionParser();
$this->loader = new ArrayLoader($this->versionParser);
$this->httpDownloader = $httpDownloader;
$this->eventDispatcher = $eventDispatcher;
$this->repoConfig = $repoConfig;
$this->loop = new Loop($this->httpDownloader);
}

public function getRepoName()
{
return 'composer repo ('.Url::sanitize($this->url).')';
}

public function getRepoConfig()
{
return $this->repoConfig;
}




public function findPackage($name, $constraint)
{

$hasProviders = $this->hasProviders();

$name = strtolower($name);
if (!$constraint instanceof ConstraintInterface) {
$constraint = $this->versionParser->parseConstraints($constraint);
}

if ($this->lazyProvidersUrl) {
if ($this->hasPartialPackages() && isset($this->partialPackagesByName[$name])) {
return $this->filterPackages($this->whatProvides($name), $constraint, true);
}

if ($this->hasAvailablePackageList && !$this->lazyProvidersRepoContains($name)) {
return null;
}

$packages = $this->loadAsyncPackages(array($name => $constraint));

return reset($packages['packages']);
}

if ($hasProviders) {
foreach ($this->getProviderNames() as $providerName) {
if ($name === $providerName) {
return $this->filterPackages($this->whatProvides($providerName), $constraint, true);
}
}

return null;
}

return parent::findPackage($name, $constraint);
}




public function findPackages($name, $constraint = null)
{

$hasProviders = $this->hasProviders();

$name = strtolower($name);
if (null !== $constraint && !$constraint instanceof ConstraintInterface) {
$constraint = $this->versionParser->parseConstraints($constraint);
}

if ($this->lazyProvidersUrl) {
if ($this->hasPartialPackages() && isset($this->partialPackagesByName[$name])) {
return $this->filterPackages($this->whatProvides($name), $constraint);
}

if ($this->hasAvailablePackageList && !$this->lazyProvidersRepoContains($name)) {
return array();
}

$result = $this->loadAsyncPackages(array($name => $constraint));

return $result['packages'];
}

if ($hasProviders) {
foreach ($this->getProviderNames() as $providerName) {
if ($name === $providerName) {
return $this->filterPackages($this->whatProvides($providerName), $constraint);
}
}

return array();
}

return parent::findPackages($name, $constraint);
}








private function filterPackages(array $packages, $constraint = null, $returnFirstMatch = false)
{
if (null === $constraint) {
if ($returnFirstMatch) {
return reset($packages);
}

return $packages;
}

$filteredPackages = array();

foreach ($packages as $package) {
$pkgConstraint = new Constraint('==', $package->getVersion());

if ($constraint->matches($pkgConstraint)) {
if ($returnFirstMatch) {
return $package;
}

$filteredPackages[] = $package;
}
}

if ($returnFirstMatch) {
return null;
}

return $filteredPackages;
}

public function getPackages()
{
$hasProviders = $this->hasProviders();

if ($this->lazyProvidersUrl) {
if (is_array($this->availablePackages) && !$this->availablePackagePatterns) {
$packageMap = array();
foreach ($this->availablePackages as $name) {
$packageMap[$name] = new MatchAllConstraint();
}

$result = $this->loadAsyncPackages($packageMap);

return array_values($result['packages']);
}

if ($this->hasPartialPackages()) {
return array_values($this->partialPackagesByName);
}

throw new \LogicException('Composer repositories that have lazy providers and no available-packages list can not load the complete list of packages, use getPackageNames instead.');
}

if ($hasProviders) {
throw new \LogicException('Composer repositories that have providers can not load the complete list of packages, use getPackageNames instead.');
}

return parent::getPackages();
}






public function getPackageNames($packageFilter = null)
{
$hasProviders = $this->hasProviders();

$packageFilterCb = function ($name) {
return true;
};
if (null !== $packageFilter) {
$packageFilterRegex = '{^'.str_replace('\\*', '.*?', preg_quote($packageFilter)).'$}i';
$packageFilterCb = function ($name) use ($packageFilterRegex) {
return (bool) preg_match($packageFilterRegex, $name);
};
}

if ($this->lazyProvidersUrl) {
if (is_array($this->availablePackages)) {
return array_filter(array_keys($this->availablePackages), $packageFilterCb);
}

if ($this->listUrl) {
$url = $this->listUrl;
if ($packageFilter) {
$url .= '?filter='.urlencode($packageFilter);
}

$result = $this->httpDownloader->get($url, $this->options)->decodeJson();

return $result['packageNames'];
}

if ($this->hasPartialPackages()) {
return array_filter(array_keys($this->partialPackagesByName), $packageFilterCb);
}

return array();
}

if ($hasProviders) {
return array_filter($this->getProviderNames(), $packageFilterCb);
}

$names = array();
foreach ($this->getPackages() as $package) {
if ($packageFilterCb($package->getName())) {
$names[] = $package->getPrettyName();
}
}

return $names;
}

public function loadPackages(array $packageNameMap, array $acceptableStabilities, array $stabilityFlags, array $alreadyLoaded = array())
{

$hasProviders = $this->hasProviders();

if (!$hasProviders && !$this->hasPartialPackages() && !$this->lazyProvidersUrl) {
return parent::loadPackages($packageNameMap, $acceptableStabilities, $stabilityFlags, $alreadyLoaded);
}

$packages = array();
$namesFound = array();

if ($hasProviders || $this->hasPartialPackages()) {
foreach ($packageNameMap as $name => $constraint) {
$matches = array();



if (!$hasProviders && !isset($this->partialPackagesByName[$name])) {
continue;
}

$candidates = $this->whatProvides($name, $acceptableStabilities, $stabilityFlags, $alreadyLoaded);
foreach ($candidates as $candidate) {
if ($candidate->getName() !== $name) {
throw new \LogicException('whatProvides should never return a package with a different name than the requested one');
}
$namesFound[$name] = true;

if (!$constraint || $constraint->matches(new Constraint('==', $candidate->getVersion()))) {
$matches[spl_object_hash($candidate)] = $candidate;
if ($candidate instanceof AliasPackage && !isset($matches[spl_object_hash($candidate->getAliasOf())])) {
$matches[spl_object_hash($candidate->getAliasOf())] = $candidate->getAliasOf();
}
}
}


foreach ($candidates as $candidate) {
if ($candidate instanceof AliasPackage) {
if (isset($matches[spl_object_hash($candidate->getAliasOf())])) {
$matches[spl_object_hash($candidate)] = $candidate;
}
}
}
$packages = array_merge($packages, $matches);

unset($packageNameMap[$name]);
}
}

if ($this->lazyProvidersUrl && count($packageNameMap)) {
if ($this->hasAvailablePackageList) {
foreach ($packageNameMap as $name => $constraint) {
if (!$this->lazyProvidersRepoContains(strtolower($name))) {
unset($packageNameMap[$name]);
}
}
}

$result = $this->loadAsyncPackages($packageNameMap, $acceptableStabilities, $stabilityFlags, $alreadyLoaded);
$packages = array_merge($packages, $result['packages']);
$namesFound = array_merge($namesFound, $result['namesFound']);
}

return array('namesFound' => array_keys($namesFound), 'packages' => $packages);
}




public function search($query, $mode = 0, $type = null)
{
$this->loadRootServerFile();

if ($this->searchUrl && $mode === self::SEARCH_FULLTEXT) {
$url = str_replace(array('%query%', '%type%'), array($query, $type), $this->searchUrl);

$search = $this->httpDownloader->get($url, $this->options)->decodeJson();

if (empty($search['results'])) {
return array();
}

$results = array();
foreach ($search['results'] as $result) {

if (!empty($result['virtual'])) {
continue;
}

$results[] = $result;
}

return $results;
}

if ($this->hasProviders() || $this->lazyProvidersUrl) {
$results = array();
$regex = '{(?:'.implode('|', preg_split('{\s+}', $query)).')}i';

foreach ($this->getPackageNames() as $name) {
if (preg_match($regex, $name)) {
$results[] = array('name' => $name, 'description' => '');
}
}

return $results;
}

return parent::search($query, $mode);
}

public function getProviders($packageName)
{
$this->loadRootServerFile();
$result = array();

if ($this->providersApiUrl) {
$apiResult = $this->httpDownloader->get(str_replace('%package%', $packageName, $this->providersApiUrl), $this->options)->decodeJson();

foreach ($apiResult['providers'] as $provider) {
$result[$provider['name']] = $provider;
}

return $result;
}

if ($this->hasPartialPackages()) {
foreach ($this->partialPackagesByName as $versions) {
foreach ($versions as $candidate) {
if (isset($result[$candidate['name']]) || !isset($candidate['provide'][$packageName])) {
continue;
}
$result[$candidate['name']] = array(
'name' => $candidate['name'],
'description' => isset($candidate['description']) ? $candidate['description'] : '',
'type' => isset($candidate['type']) ? $candidate['type'] : '',
);
}
}
}

if ($this->packages) {
$result = array_merge($result, parent::getProviders($packageName));
}

return $result;
}




private function getProviderNames()
{
$this->loadRootServerFile();

if (null === $this->providerListing) {
$this->loadProviderListings($this->loadRootServerFile());
}

if ($this->lazyProvidersUrl) {

return array();
}

if ($this->providersUrl) {
return array_keys($this->providerListing);
}

return array();
}




protected function configurePackageTransportOptions(PackageInterface $package)
{
foreach ($package->getDistUrls() as $url) {
if (strpos($url, $this->baseUrl) === 0) {
$package->setTransportOptions($this->options);

return;
}
}
}




private function hasProviders()
{
$this->loadRootServerFile();

return $this->hasProviders;
}











private function whatProvides($name, array $acceptableStabilities = null, array $stabilityFlags = null, array $alreadyLoaded = array())
{
$packagesSource = null;
if (!$this->hasPartialPackages() || !isset($this->partialPackagesByName[$name])) {

if (PlatformRepository::isPlatformPackage($name) || '__root__' === $name) {
return array();
}

if (null === $this->providerListing) {
$this->loadProviderListings($this->loadRootServerFile());
}

$useLastModifiedCheck = false;
if ($this->lazyProvidersUrl && !isset($this->providerListing[$name])) {
$hash = null;
$url = str_replace('%package%', $name, $this->lazyProvidersUrl);
$cacheKey = 'provider-'.strtr($name, '/', '$').'.json';
$useLastModifiedCheck = true;
} elseif ($this->providersUrl) {

if (!isset($this->providerListing[$name])) {
return array();
}

$hash = $this->providerListing[$name]['sha256'];
$url = str_replace(array('%package%', '%hash%'), array($name, $hash), $this->providersUrl);
$cacheKey = 'provider-'.strtr($name, '/', '$').'.json';
} else {
return array();
}

$packages = null;
if (!$useLastModifiedCheck && $hash && $this->cache->sha256($cacheKey) === $hash) {
$packages = json_decode($this->cache->read($cacheKey), true);
$packagesSource = 'cached file ('.$cacheKey.' originating from '.Url::sanitize($url).')';
} elseif ($useLastModifiedCheck) {
if ($contents = $this->cache->read($cacheKey)) {
$contents = json_decode($contents, true);

if (isset($alreadyLoaded[$name])) {
$packages = $contents;
$packagesSource = 'cached file ('.$cacheKey.' originating from '.Url::sanitize($url).')';
} elseif (isset($contents['last-modified'])) {
$response = $this->fetchFileIfLastModified($url, $cacheKey, $contents['last-modified']);
$packages = true === $response ? $contents : $response;
$packagesSource = true === $response ? 'cached file ('.$cacheKey.' originating from '.Url::sanitize($url).')' : 'downloaded file ('.Url::sanitize($url).')';
}
}
}

if (!$packages) {
try {
$packages = $this->fetchFile($url, $cacheKey, $hash, $useLastModifiedCheck);
$packagesSource = 'downloaded file ('.Url::sanitize($url).')';
} catch (TransportException $e) {

if ($this->lazyProvidersUrl && in_array($e->getStatusCode(), array(404, 499), true)) {
$packages = array('packages' => array());
$packagesSource = 'not-found file ('.Url::sanitize($url).')';
if ($e->getStatusCode() === 499) {
$this->io->error('<warning>' . $e->getMessage() . '</warning>');
}
} else {
throw $e;
}
}
}

$loadingPartialPackage = false;
} else {
$packages = array('packages' => array('versions' => $this->partialPackagesByName[$name]));
$packagesSource = 'root file ('.Url::sanitize($this->getPackagesJsonUrl()).')';
$loadingPartialPackage = true;
}

$result = array();
$versionsToLoad = array();
foreach ($packages['packages'] as $versions) {
foreach ($versions as $version) {
$normalizedName = strtolower($version['name']);


if ($normalizedName !== $name) {
continue;
}

if (!$loadingPartialPackage && $this->hasPartialPackages() && isset($this->partialPackagesByName[$normalizedName])) {
continue;
}

if (!isset($versionsToLoad[$version['uid']])) {
if (!isset($version['version_normalized'])) {
$version['version_normalized'] = $this->versionParser->normalize($version['version']);
} elseif ($version['version_normalized'] === VersionParser::DEFAULT_BRANCH_ALIAS) {

$version['version_normalized'] = $this->versionParser->normalize($version['version']);
}


if (isset($alreadyLoaded[$name][$version['version_normalized']])) {
continue;
}

if ($this->isVersionAcceptable(null, $normalizedName, $version, $acceptableStabilities, $stabilityFlags)) {
$versionsToLoad[$version['uid']] = $version;
}
}
}
}


$loadedPackages = $this->createPackages($versionsToLoad, $packagesSource);
$uids = array_keys($versionsToLoad);

foreach ($loadedPackages as $index => $package) {
$package->setRepository($this);
$uid = $uids[$index];

if ($package instanceof AliasPackage) {
$aliased = $package->getAliasOf();
$aliased->setRepository($this);

$result[$uid] = $aliased;
$result[$uid.'-alias'] = $package;
} else {
$result[$uid] = $package;
}
}

return $result;
}




protected function initialize()
{
parent::initialize();

$repoData = $this->loadDataFromServer();

foreach ($this->createPackages($repoData, 'root file ('.Url::sanitize($this->getPackagesJsonUrl()).')') as $package) {
$this->addPackage($package);
}
}






public function addPackage(PackageInterface $package)
{
parent::addPackage($package);
$this->configurePackageTransportOptions($package);
}











private function loadAsyncPackages(array $packageNames, array $acceptableStabilities = null, array $stabilityFlags = null, array $alreadyLoaded = array())
{
$this->loadRootServerFile();

$packages = array();
$namesFound = array();
$promises = array();
$repo = $this;

if (!$this->lazyProvidersUrl) {
throw new \LogicException('loadAsyncPackages only supports v2 protocol composer repos with a metadata-url');
}


foreach ($packageNames as $name => $constraint) {
if ($acceptableStabilities === null || $stabilityFlags === null || StabilityFilter::isPackageAcceptable($acceptableStabilities, $stabilityFlags, array($name), 'dev')) {
$packageNames[$name.'~dev'] = $constraint;
}

if (isset($acceptableStabilities['dev']) && count($acceptableStabilities) === 1 && count($stabilityFlags) === 0) {
unset($packageNames[$name]);
}
}

foreach ($packageNames as $name => $constraint) {
$name = strtolower($name);

$realName = preg_replace('{~dev$}', '', $name);

if (PlatformRepository::isPlatformPackage($realName) || '__root__' === $realName) {
continue;
}

$url = str_replace('%package%', $name, $this->lazyProvidersUrl);
$cacheKey = 'provider-'.strtr($name, '/', '~').'.json';

$lastModified = null;
if ($contents = $this->cache->read($cacheKey)) {
$contents = json_decode($contents, true);
$lastModified = isset($contents['last-modified']) ? $contents['last-modified'] : null;
}

$promises[] = $this->asyncFetchFile($url, $cacheKey, $lastModified)
->then(function ($response) use (&$packages, &$namesFound, $url, $cacheKey, $contents, $realName, $constraint, $repo, $acceptableStabilities, $stabilityFlags, $alreadyLoaded) {
$packagesSource = 'downloaded file ('.Url::sanitize($url).')';

if (true === $response) {
$packagesSource = 'cached file ('.$cacheKey.' originating from '.Url::sanitize($url).')';
$response = $contents;
}

if (!isset($response['packages'][$realName])) {
return;
}

$versions = $response['packages'][$realName];

if (isset($response['minified']) && $response['minified'] === 'composer/2.0') {
$versions = MetadataMinifier::expand($versions);
}

$namesFound[$realName] = true;
$versionsToLoad = array();
foreach ($versions as $version) {
if (!isset($version['version_normalized'])) {
$version['version_normalized'] = $repo->versionParser->normalize($version['version']);
} elseif ($version['version_normalized'] === VersionParser::DEFAULT_BRANCH_ALIAS) {

$version['version_normalized'] = $repo->versionParser->normalize($version['version']);
}


if (isset($alreadyLoaded[$realName][$version['version_normalized']])) {
continue;
}

if ($repo->isVersionAcceptable($constraint, $realName, $version, $acceptableStabilities, $stabilityFlags)) {
$versionsToLoad[] = $version;
}
}

$loadedPackages = $repo->createPackages($versionsToLoad, $packagesSource);
foreach ($loadedPackages as $package) {
$package->setRepository($repo);
$packages[spl_object_hash($package)] = $package;

if ($package instanceof AliasPackage && !isset($packages[spl_object_hash($package->getAliasOf())])) {
$package->getAliasOf()->setRepository($repo);
$packages[spl_object_hash($package->getAliasOf())] = $package->getAliasOf();
}
}
});
}

$this->loop->wait($promises);

return array('namesFound' => $namesFound, 'packages' => $packages);

}
















public function isVersionAcceptable($constraint, $name, $versionData, array $acceptableStabilities = null, array $stabilityFlags = null)
{
$versions = array($versionData['version_normalized']);

if ($alias = $this->loader->getBranchAlias($versionData)) {
$versions[] = $alias;
}

foreach ($versions as $version) {
if (null !== $acceptableStabilities && null !== $stabilityFlags && !StabilityFilter::isPackageAcceptable($acceptableStabilities, $stabilityFlags, array($name), VersionParser::parseStability($version))) {
continue;
}

if ($constraint && !CompilingMatcher::match($constraint, Constraint::OP_EQ, $version)) {
continue;
}

return true;
}

return false;
}




private function getPackagesJsonUrl()
{
$jsonUrlParts = parse_url($this->url);

if (isset($jsonUrlParts['path']) && false !== strpos($jsonUrlParts['path'], '.json')) {
return $this->url;
}

return $this->url . '/packages.json';
}




protected function loadRootServerFile()
{
if (null !== $this->rootData) {
return $this->rootData;
}

if (!extension_loaded('openssl') && strpos($this->url, 'https') === 0) {
throw new \RuntimeException('You must enable the openssl extension in your php.ini to load information from '.$this->url);
}

$data = $this->fetchFile($this->getPackagesJsonUrl(), 'packages.json');

if (!empty($data['notify-batch'])) {
$this->notifyUrl = $this->canonicalizeUrl($data['notify-batch']);
} elseif (!empty($data['notify'])) {
$this->notifyUrl = $this->canonicalizeUrl($data['notify']);
}

if (!empty($data['search'])) {
$this->searchUrl = $this->canonicalizeUrl($data['search']);
}

if (!empty($data['mirrors'])) {
foreach ($data['mirrors'] as $mirror) {
if (!empty($mirror['git-url'])) {
$this->sourceMirrors['git'][] = array('url' => $mirror['git-url'], 'preferred' => !empty($mirror['preferred']));
}
if (!empty($mirror['hg-url'])) {
$this->sourceMirrors['hg'][] = array('url' => $mirror['hg-url'], 'preferred' => !empty($mirror['preferred']));
}
if (!empty($mirror['dist-url'])) {
$this->distMirrors[] = array(
'url' => $this->canonicalizeUrl($mirror['dist-url']),
'preferred' => !empty($mirror['preferred']),
);
}
}
}

if (!empty($data['providers-lazy-url'])) {
$this->lazyProvidersUrl = $this->canonicalizeUrl($data['providers-lazy-url']);
$this->hasProviders = true;

$this->hasPartialPackages = !empty($data['packages']) && is_array($data['packages']);
}


if (!empty($data['metadata-url']) && !empty($data['list']) && $data['metadata-url'] === '/p/%package%.json' && $data['list'] === 'https://packagist.org/packages/list.json') {
$this->io->writeError('<warning>Composer 2 repository support for '.$this->url.' has been disabled due to what seems like a misconfiguration. If this is a packagist.org mirror we recommend removing it as Composer 2 handles network operations much faster and should work fine without.</warning>');
unset($data['metadata-url']);
}




if (!empty($data['metadata-url'])) {
$this->lazyProvidersUrl = $this->canonicalizeUrl($data['metadata-url']);
$this->providersUrl = null;
$this->hasProviders = false;
$this->hasPartialPackages = !empty($data['packages']) && is_array($data['packages']);
$this->allowSslDowngrade = false;




if (!empty($data['available-packages'])) {
$availPackages = array_map('strtolower', $data['available-packages']);
$this->availablePackages = array_combine($availPackages, $availPackages);
$this->hasAvailablePackageList = true;
}




if (!empty($data['available-package-patterns'])) {
$this->availablePackagePatterns = array_map(function ($pattern) {
return BasePackage::packageNameToRegexp($pattern);
}, $data['available-package-patterns']);
$this->hasAvailablePackageList = true;
}



unset($data['providers-url'], $data['providers'], $data['providers-includes']);
}

if ($this->allowSslDowngrade) {
$this->url = str_replace('https://', 'http://', $this->url);
$this->baseUrl = str_replace('https://', 'http://', $this->baseUrl);
}

if (!empty($data['providers-url'])) {
$this->providersUrl = $this->canonicalizeUrl($data['providers-url']);
$this->hasProviders = true;
}

if (!empty($data['list'])) {
$this->listUrl = $this->canonicalizeUrl($data['list']);
}

if (!empty($data['providers']) || !empty($data['providers-includes'])) {
$this->hasProviders = true;
}

if (!empty($data['providers-api'])) {
$this->providersApiUrl = $this->canonicalizeUrl($data['providers-api']);
}

return $this->rootData = $data;
}






private function canonicalizeUrl($url)
{
if ('/' === $url[0]) {
if (preg_match('{^[^:]++://[^/]*+}', $this->url, $matches)) {
return $matches[0] . $url;
}

return $this->url;
}

return $url;
}




private function loadDataFromServer()
{
$data = $this->loadRootServerFile();

return $this->loadIncludes($data);
}




private function hasPartialPackages()
{
if ($this->hasPartialPackages && null === $this->partialPackagesByName) {
$this->initializePartialPackages();
}

return $this->hasPartialPackages;
}






private function loadProviderListings($data)
{
if (isset($data['providers'])) {
if (!is_array($this->providerListing)) {
$this->providerListing = array();
}
$this->providerListing = array_merge($this->providerListing, $data['providers']);
}

if ($this->providersUrl && isset($data['provider-includes'])) {
$includes = $data['provider-includes'];
foreach ($includes as $include => $metadata) {
$url = $this->baseUrl . '/' . str_replace('%hash%', $metadata['sha256'], $include);
$cacheKey = str_replace(array('%hash%','$'), '', $include);
if ($this->cache->sha256($cacheKey) === $metadata['sha256']) {
$includedData = json_decode($this->cache->read($cacheKey), true);
} else {
$includedData = $this->fetchFile($url, $cacheKey, $metadata['sha256']);
}

$this->loadProviderListings($includedData);
}
}
}






private function loadIncludes($data)
{
$packages = array();


if (!isset($data['packages']) && !isset($data['includes'])) {
foreach ($data as $pkg) {
if (isset($pkg['versions']) && is_array($pkg['versions'])) {
foreach ($pkg['versions'] as $metadata) {
$packages[] = $metadata;
}
}
}

return $packages;
}

if (isset($data['packages'])) {
foreach ($data['packages'] as $package => $versions) {
foreach ($versions as $version => $metadata) {
$packages[] = $metadata;
}
}
}

if (isset($data['includes'])) {
foreach ($data['includes'] as $include => $metadata) {
if (isset($metadata['sha1']) && $this->cache->sha1((string) $include) === $metadata['sha1']) {
$includedData = json_decode($this->cache->read((string) $include), true);
} else {
$includedData = $this->fetchFile($include);
}
$packages = array_merge($packages, $this->loadIncludes($includedData));
}
}

return $packages;
}










public function createPackages(array $packages, $source = null)
{
if (!$packages) {
return array();
}

try {
foreach ($packages as &$data) {
if (!isset($data['notification-url'])) {
$data['notification-url'] = $this->notifyUrl;
}
}

$packageInstances = $this->loader->loadPackages($packages);

foreach ($packageInstances as $package) {
if (isset($this->sourceMirrors[$package->getSourceType()])) {
$package->setSourceMirrors($this->sourceMirrors[$package->getSourceType()]);
}
$package->setDistMirrors($this->distMirrors);
$this->configurePackageTransportOptions($package);
}

return $packageInstances;
} catch (\Exception $e) {
throw new \RuntimeException('Could not load packages '.(isset($packages[0]['name']) ? $packages[0]['name'] : json_encode($packages)).' in '.$this->getRepoName().($source ? ' from '.$source : '').': ['.get_class($e).'] '.$e->getMessage(), 0, $e);
}
}









protected function fetchFile($filename, $cacheKey = null, $sha256 = null, $storeLastModifiedTime = false)
{
if (null === $cacheKey) {
$cacheKey = $filename;
$filename = $this->baseUrl.'/'.$filename;
}


if (($pos = strpos($filename, '$')) && preg_match('{^https?://}i', $filename)) {
$filename = substr($filename, 0, $pos) . '%24' . substr($filename, $pos + 1);
}

$retries = 3;
while ($retries--) {
try {
$options = $this->options;
if ($this->eventDispatcher) {
$preFileDownloadEvent = new PreFileDownloadEvent(PluginEvents::PRE_FILE_DOWNLOAD, $this->httpDownloader, $filename, 'metadata', array('repository' => $this));
$preFileDownloadEvent->setTransportOptions($this->options);
$this->eventDispatcher->dispatch($preFileDownloadEvent->getName(), $preFileDownloadEvent);
$filename = $preFileDownloadEvent->getProcessedUrl();
$options = $preFileDownloadEvent->getTransportOptions();
}

$response = $this->httpDownloader->get($filename, $options);
$json = (string) $response->getBody();
if ($sha256 && $sha256 !== hash('sha256', $json)) {

if ($this->allowSslDowngrade) {
$this->url = str_replace('http://', 'https://', $this->url);
$this->baseUrl = str_replace('http://', 'https://', $this->baseUrl);
$filename = str_replace('http://', 'https://', $filename);
}

if ($retries) {
usleep(100000);

continue;
}


throw new RepositorySecurityException('The contents of '.$filename.' do not match its signature. This could indicate a man-in-the-middle attack or e.g. antivirus software corrupting files. Try running composer again and report this if you think it is a mistake.');
}

if ($this->eventDispatcher) {
$postFileDownloadEvent = new PostFileDownloadEvent(PluginEvents::POST_FILE_DOWNLOAD, null, $sha256, $filename, 'metadata', array('response' => $response, 'repository' => $this));
$this->eventDispatcher->dispatch($postFileDownloadEvent->getName(), $postFileDownloadEvent);
}

$data = $response->decodeJson();
HttpDownloader::outputWarnings($this->io, $this->url, $data);

if ($cacheKey && !$this->cache->isReadOnly()) {
if ($storeLastModifiedTime) {
$lastModifiedDate = $response->getHeader('last-modified');
if ($lastModifiedDate) {
$data['last-modified'] = $lastModifiedDate;
$json = JsonFile::encode($data, 0);
}
}
$this->cache->write($cacheKey, $json);
}

$response->collect();

break;
} catch (\Exception $e) {
if ($e instanceof \LogicException) {
throw $e;
}

if ($e instanceof TransportException && $e->getStatusCode() === 404) {
throw $e;
}


if ($e instanceof TransportException && $e->getStatusCode() === null) {
$responseInfo = $e->getResponseInfo();
if (isset($responseInfo['namelookup_time']) && $responseInfo['namelookup_time'] == 0) {
$retries = 0;
}
}

if ($retries) {
usleep(100000);
continue;
}

if ($e instanceof RepositorySecurityException) {
throw $e;
}

if ($cacheKey && ($contents = $this->cache->read($cacheKey))) {
if (!$this->degradedMode) {
$this->io->writeError('<warning>'.$this->url.' could not be fully loaded ('.$e->getMessage().'), package information was loaded from the local cache and may be out of date</warning>');
}
$this->degradedMode = true;
$data = JsonFile::parseJson($contents, $this->cache->getRoot().$cacheKey);

break;
}

throw $e;
}
}

if (!isset($data)) {
throw new \LogicException("ComposerRepository: Undefined \$data. Please report at https://github.com/composer/composer/issues/new.");
}

return $data;
}








private function fetchFileIfLastModified($filename, $cacheKey, $lastModifiedTime)
{
$retries = 3;
while ($retries--) {
try {
$options = $this->options;
if ($this->eventDispatcher) {
$preFileDownloadEvent = new PreFileDownloadEvent(PluginEvents::PRE_FILE_DOWNLOAD, $this->httpDownloader, $filename, 'metadata', array('repository' => $this));
$preFileDownloadEvent->setTransportOptions($this->options);
$this->eventDispatcher->dispatch($preFileDownloadEvent->getName(), $preFileDownloadEvent);
$filename = $preFileDownloadEvent->getProcessedUrl();
$options = $preFileDownloadEvent->getTransportOptions();
}

if (isset($options['http']['header'])) {
$options['http']['header'] = (array) $options['http']['header'];
}
$options['http']['header'][] = 'If-Modified-Since: '.$lastModifiedTime;
$response = $this->httpDownloader->get($filename, $options);
$json = (string) $response->getBody();
if ($json === '' && $response->getStatusCode() === 304) {
return true;
}

if ($this->eventDispatcher) {
$postFileDownloadEvent = new PostFileDownloadEvent(PluginEvents::POST_FILE_DOWNLOAD, null, null, $filename, 'metadata', array('response' => $response, 'repository' => $this));
$this->eventDispatcher->dispatch($postFileDownloadEvent->getName(), $postFileDownloadEvent);
}

$data = $response->decodeJson();
HttpDownloader::outputWarnings($this->io, $this->url, $data);

$lastModifiedDate = $response->getHeader('last-modified');
$response->collect();
if ($lastModifiedDate) {
$data['last-modified'] = $lastModifiedDate;
$json = JsonFile::encode($data, 0);
}
if (!$this->cache->isReadOnly()) {
$this->cache->write($cacheKey, $json);
}

return $data;
} catch (\Exception $e) {
if ($e instanceof \LogicException) {
throw $e;
}

if ($e instanceof TransportException && $e->getStatusCode() === 404) {
throw $e;
}

if ($retries) {
usleep(100000);
continue;
}

if (!$this->degradedMode) {
$this->io->writeError('<warning>'.$this->url.' could not be fully loaded ('.$e->getMessage().'), package information was loaded from the local cache and may be out of date</warning>');
}
$this->degradedMode = true;

return true;
}
}

throw new \LogicException('Should not happen');
}








private function asyncFetchFile($filename, $cacheKey, $lastModifiedTime = null)
{
$retries = 3;

if (isset($this->packagesNotFoundCache[$filename])) {
return \React\Promise\resolve(array('packages' => array()));
}

if (isset($this->freshMetadataUrls[$filename]) && $lastModifiedTime) {

return \React\Promise\resolve(true);
}

$httpDownloader = $this->httpDownloader;
$options = $this->options;
if ($this->eventDispatcher) {
$preFileDownloadEvent = new PreFileDownloadEvent(PluginEvents::PRE_FILE_DOWNLOAD, $this->httpDownloader, $filename, 'metadata', array('repository' => $this));
$preFileDownloadEvent->setTransportOptions($this->options);
$this->eventDispatcher->dispatch($preFileDownloadEvent->getName(), $preFileDownloadEvent);
$filename = $preFileDownloadEvent->getProcessedUrl();
$options = $preFileDownloadEvent->getTransportOptions();
}

if ($lastModifiedTime) {
if (isset($options['http']['header'])) {
$options['http']['header'] = (array) $options['http']['header'];
}
$options['http']['header'][] = 'If-Modified-Since: '.$lastModifiedTime;
}

$io = $this->io;
$url = $this->url;
$cache = $this->cache;
$degradedMode = &$this->degradedMode;
$eventDispatcher = $this->eventDispatcher;
$repo = $this;

$accept = function ($response) use ($io, $url, $filename, $cache, $cacheKey, $eventDispatcher, $repo) {

if ($response->getStatusCode() === 404) {
$repo->packagesNotFoundCache[$filename] = true;

return array('packages' => array());
}

$json = (string) $response->getBody();
if ($json === '' && $response->getStatusCode() === 304) {
$repo->freshMetadataUrls[$filename] = true;

return true;
}

if ($eventDispatcher) {
$postFileDownloadEvent = new PostFileDownloadEvent(PluginEvents::POST_FILE_DOWNLOAD, null, null, $filename, 'metadata', array('response' => $response, 'repository' => $repo));
$eventDispatcher->dispatch($postFileDownloadEvent->getName(), $postFileDownloadEvent);
}

$data = $response->decodeJson();
HttpDownloader::outputWarnings($io, $url, $data);

$lastModifiedDate = $response->getHeader('last-modified');
$response->collect();
if ($lastModifiedDate) {
$data['last-modified'] = $lastModifiedDate;
$json = JsonFile::encode($data, JsonFile::JSON_UNESCAPED_SLASHES | JsonFile::JSON_UNESCAPED_UNICODE);
}
if (!$cache->isReadOnly()) {
$cache->write($cacheKey, $json);
}
$repo->freshMetadataUrls[$filename] = true;

return $data;
};

$reject = function ($e) use (&$retries, $httpDownloader, $filename, $options, &$reject, $accept, $io, $url, &$degradedMode, $repo, $lastModifiedTime) {
if ($e instanceof TransportException && $e->getStatusCode() === 404) {
$repo->packagesNotFoundCache[$filename] = true;

return false;
}


if ($e instanceof TransportException && $e->getStatusCode() === 499) {
$retries = 0;
}


if ($e instanceof TransportException && $e->getStatusCode() === null) {
$responseInfo = $e->getResponseInfo();
if (isset($responseInfo['namelookup_time']) && $responseInfo['namelookup_time'] == 0) {
$retries = 0;
}
}

if (--$retries > 0) {
usleep(100000);

return $httpDownloader->add($filename, $options)->then($accept, $reject);
}

if (!$degradedMode) {
$io->writeError('<warning>'.$url.' could not be fully loaded ('.$e->getMessage().'), package information was loaded from the local cache and may be out of date</warning>');
}
$degradedMode = true;


if ($lastModifiedTime) {
return $accept(new Response(array('url' => $url), 304, array(), ''));
}


if ($e instanceof TransportException && $e->getStatusCode() === 499) {
return $accept(new Response(array('url' => $url), 404, array(), ''));
}

throw $e;
};

return $httpDownloader->add($filename, $options)->then($accept, $reject);
}








private function initializePartialPackages()
{
$rootData = $this->loadRootServerFile();

$this->partialPackagesByName = array();
foreach ($rootData['packages'] as $package => $versions) {
foreach ($versions as $version) {
$this->partialPackagesByName[strtolower($version['name'])][] = $version;
}
}


$this->rootData = true;
}







protected function lazyProvidersRepoContains($name)
{
if (!$this->hasAvailablePackageList) {
throw new \LogicException('lazyProvidersRepoContains should not be called unless hasAvailablePackageList is true');
}

if (is_array($this->availablePackages) && isset($this->availablePackages[$name])) {
return true;
}

if (is_array($this->availablePackagePatterns)) {
foreach ($this->availablePackagePatterns as $providerRegex) {
if (preg_match($providerRegex, $name)) {
return true;
}
}
}

return false;
}
}
