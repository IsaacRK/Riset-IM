<?php











namespace Composer\Package\Loader;

use Composer\Package\CompletePackageInterface;
use Composer\Package\CompletePackage;
use Composer\Package\CompleteAliasPackage;
use Composer\Package\RootAliasPackage;
use Composer\Package\RootPackage;






interface LoaderInterface
{












public function load(array $config, $class = 'Composer\Package\CompletePackage');
}
