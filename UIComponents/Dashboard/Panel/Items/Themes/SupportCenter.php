<?php

namespace Harryn\Jacobn\SupportCenterBundle\UIComponents\Dashboard\Panel\Items\Themes;

use Harryn\Jacobn\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Harryn\Jacobn\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars\Branding;

class SupportCenter implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Support Center";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_knowledgebase_theme';
    }

    public static function getSupportedRoutes() : array
    {
        return [];
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_KNOWLEDGEBASE'];
    }

    public static function getSidebarReferenceId() : string
    {
        return Branding::class;
    }
}
