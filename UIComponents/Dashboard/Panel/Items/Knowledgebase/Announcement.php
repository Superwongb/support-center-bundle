<?php

namespace Harryn\Jacobn\SupportCenterBundle\UIComponents\Dashboard\Panel\Items\Knowledgebase;

use Harryn\Jacobn\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Harryn\Jacobn\SupportCenterBundle\UIComponents\Dashboard\Panel\Sidebars\Knowledgebase;

class Announcement implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Announcement";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_knowledgebase_marketing_announcement';
    }

    public static function getSupportedRoutes() : array
    {
        return [
            'helpdesk_member_knowledgebase_create_marketing_announcement',
            'helpdesk_member_knowledgebase_update_marketing_announcement', 
            'helpdesk_member_knowledgebase_marketing_announcement',
        ];
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_KNOWLEDGEBASE'];
    }

    public static function getSidebarReferenceId() : string
    {
        return Knowledgebase::class;
    }
}
