<?php

namespace Harryn\Jacobn\SupportCenterBundle\Package;

use Harryn\Jacobn\PackageManager\Composer\ComposerPackage;
use Harryn\Jacobn\PackageManager\Composer\ComposerPackageExtension;

class Composer extends ComposerPackageExtension
{
    public function loadConfiguration()
    {
        $composerPackage = new ComposerPackage();
        $composerPackage
            ->combineProjectConfig('config/packages/security.yaml', 'Templates/security.yaml');
        
        return $composerPackage;
    }
}
