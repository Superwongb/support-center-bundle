<?php

namespace Harryn\Jacobn\SupportCenterBundle\Routing;

use Harryn\Jacobn\CoreFrameworkBundle\Definition\RoutingResourceInterface;

class RoutingResource implements RoutingResourceInterface
{
    public static function getResourcePath()
    {
        return __DIR__ . "/../Resources/config/routes.yaml";
    }

    public static function getResourceType()
    {
        return RoutingResourceInterface::YAML_RESOURCE;
    }
}
