<?php











namespace Composer\Downloader;

use Composer\Package\PackageInterface;
use Symfony\Component\Finder\Finder;
use React\Promise\PromiseInterface;
use Composer\DependencyResolver\Operation\InstallOperation;








abstract class ArchiveDownloader extends FileDownloader
{




public $cleanupExecuted = array();




public function prepare($type, PackageInterface $package, $path, PackageInterface $prevPackage = null)
{
unset($this->cleanupExecuted[$package->getName()]);

return parent::prepare($type, $package, $path, $prevPackage);
}




public function cleanup($type, PackageInterface $package, $path, PackageInterface $prevPackage = null)
{
$this->cleanupExecuted[$package->getName()] = true;

return parent::cleanup($type, $package, $path, $prevPackage);
}











public function install(PackageInterface $package, $path, $output = true)
{
if ($output) {
$this->io->writeError("  - " . InstallOperation::format($package) . $this->getInstallOperationAppendix($package, $path));
}

$vendorDir = $this->config->get('vendor-dir');




if (false === strpos($this->filesystem->normalizePath($vendorDir), $this->filesystem->normalizePath($path.DIRECTORY_SEPARATOR))) {
$this->filesystem->emptyDirectory($path);
}

do {
$temporaryDir = $vendorDir.'/composer/'.substr(md5(uniqid('', true)), 0, 8);
} while (is_dir($temporaryDir));

$this->addCleanupPath($package, $temporaryDir);


if (!is_dir($path) || realpath($path) !== getcwd()) {
$this->addCleanupPath($package, $path);
}

$this->filesystem->ensureDirectoryExists($temporaryDir);
$fileName = $this->getFileName($package, $path);

$filesystem = $this->filesystem;
$self = $this;

$cleanup = function () use ($path, $filesystem, $temporaryDir, $package, $self) {

$self->clearLastCacheWrite($package);


$filesystem->removeDirectory($temporaryDir);
if (is_dir($path) && realpath($path) !== getcwd()) {
$filesystem->removeDirectory($path);
}
$self->removeCleanupPath($package, $temporaryDir);
$self->removeCleanupPath($package, realpath($path));
};

$promise = null;
try {
$promise = $this->extract($package, $fileName, $temporaryDir);
} catch (\Exception $e) {
$cleanup();
throw $e;
}

if (!$promise instanceof PromiseInterface) {
$promise = \React\Promise\resolve();
}

return $promise->then(function () use ($self, $package, $filesystem, $fileName, $temporaryDir, $path) {
$filesystem->unlink($fileName);







$getFolderContent = function ($dir) {
$finder = Finder::create()
->ignoreVCS(false)
->ignoreDotFiles(false)
->notName('.DS_Store')
->depth(0)
->in($dir);

return iterator_to_array($finder);
};
$renameRecursively = null;











$renameRecursively = function ($from, $to) use ($filesystem, $getFolderContent, $package, &$renameRecursively) {
$contentDir = $getFolderContent($from);


foreach ($contentDir as $file) {
$file = (string) $file;
if (is_dir($to . '/' . basename($file))) {
if (!is_dir($file)) {
throw new \RuntimeException('Installing '.$package.' would lead to overwriting the '.$to.'/'.basename($file).' directory with a file from the package, invalid operation.');
}
$renameRecursively($file, $to . '/' . basename($file));
} else {
$filesystem->rename($file, $to . '/' . basename($file));
}
}
};

$renameAsOne = false;
if (!file_exists($path)) {
$renameAsOne = true;
} elseif ($filesystem->isDirEmpty($path)) {
try {
if ($filesystem->removeDirectoryPhp($path)) {
$renameAsOne = true;
}
} catch (\RuntimeException $e) {

}
}

$contentDir = $getFolderContent($temporaryDir);
$singleDirAtTopLevel = 1 === count($contentDir) && is_dir(reset($contentDir));

if ($renameAsOne) {

if ($singleDirAtTopLevel) {
$extractedDir = (string) reset($contentDir);
} else {
$extractedDir = $temporaryDir;
}
$filesystem->rename($extractedDir, $path);
} else {

$from = $temporaryDir;
if ($singleDirAtTopLevel) {
$from = (string) reset($contentDir);
}

$renameRecursively($from, $path);
}

$promise = $filesystem->removeDirectoryAsync($temporaryDir);

return $promise->then(function () use ($self, $package, $path, $temporaryDir) {
$self->removeCleanupPath($package, $temporaryDir);
$self->removeCleanupPath($package, $path);
});
}, function ($e) use ($cleanup) {
$cleanup();

throw $e;
});
}




protected function getInstallOperationAppendix(PackageInterface $package, $path)
{
return ': Extracting archive';
}










abstract protected function extract(PackageInterface $package, $file, $path);
}
