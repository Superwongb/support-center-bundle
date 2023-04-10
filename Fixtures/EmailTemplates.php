<?php

namespace Harryn\Jacobn\SupportCenterBundle\Fixtures;

use Doctrine\Persistence\ObjectManager;
use Harryn\Jacobn\CoreEntities\Entity as CoreEntities;
use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;
use Harryn\Jacobn\SupportCenterBundle\Templates\Email\Resources as SupportCenterEmailTemplates;

class EmailTemplates extends DoctrineFixture
{
    private static $seeds = [
        SupportCenterEmailTemplates\Customer\AccountCreated::class,
    ];

    public function load(ObjectManager $entityManager)
    {
        // $emailTemplateCollection = $entityManager->getRepository(CoreEntities\EmailTemplates::class)->findAll();

        // if (empty($emailTemplateCollection)) {
        //     foreach (self::$seeds as $coreEmailTemplate) {
        //         ($emailTemplate = new CoreEntities\EmailTemplates())
        //             ->setName($coreEmailTemplate::getName())
        //             ->setSubject($coreEmailTemplate::getSubject())
        //             ->setMessage($coreEmailTemplate::getMessage());

        //         $entityManager->persist($emailTemplate);
        //     }

        //     $entityManager->flush();
        // }
    }
}
