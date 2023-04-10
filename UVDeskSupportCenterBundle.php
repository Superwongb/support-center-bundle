<?php

namespace Harryn\Jacobn\SupportCenterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Harryn\Jacobn\SupportCenterBundle\DependencyInjection\SupportCenterExtension;

class UVDeskSupportCenterBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SupportCenterExtension();
    }
}
