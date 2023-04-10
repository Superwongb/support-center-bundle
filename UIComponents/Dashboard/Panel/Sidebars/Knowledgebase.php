<?php

namespace Harryn\Jacobn\SupportCenterBundle\UIComponents\Dashboard\Panel\Sidebars;

use Harryn\Jacobn\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarInterface;

class Knowledgebase implements PanelSidebarInterface
{
    public static function getTitle() : string
    {
        return "Knowledgebase";
    }
}
