<?php

namespace Harryn\Jacobn\SupportCenterBundle\UIComponents\Dashboard\Panel\Items\Settings;

use Harryn\Jacobn\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Harryn\Jacobn\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars\Settings;

class BlockSpam implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Spam Settings";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_knowledgebase_spam';
    }

    public static function getSupportedRoutes() : array
    {
        return [];
    }

    public static function getRoles() : array
    {
        return ['ROLE_ADMIN'];
    }

    public static function getSidebarReferenceId() : string
    {
        return Settings::class;
    }
}
