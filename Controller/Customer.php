<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webkul\UVDesk\CoreFrameworkBundle\Form\UserProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webkul\UVDesk\SupportCenterBundle\Entity\KnowledgebaseWebsite;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Website as CoreWebsite;

Class Customer extends AbstractController
{
    protected function redirectUserToLogin()
    {
        $authChecker = $this->container->get('security.authorization_checker');
        if($authChecker->isGranted('ROLE_CUSTOMER'))
            return true;
    }

    protected function isWebsiteActive()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $website = $entityManager->getRepository(CoreWebsite::class)->findOneByCode('knowledgebase');
  
        if (!empty($website)) {
            $knowledgebaseWebsite = $entityManager->getRepository(KnowledgebaseWebsite::class)->findOneBy(['website' => $website->getId(), 'status' => 1]);
            
            if (!empty($knowledgebaseWebsite) && true == $knowledgebaseWebsite->getIsActive()) {
                return true;
            }
        }

        $this->noResultFound();
    }

    protected function noResultFound()
    {
        throw new NotFoundHttpException('Permission Denied !');
    }

    protected function isLoginDisabled()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $website = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneByCode('knowledgebase');

        if (!empty($website)) {
            $configuration = $entityManager->getRepository('UVDeskSupportCenterBundle:KnowledgebaseWebsite')->findOneBy([
                'website' => $website->getId(),
                'isActive' => 1,
            ]);

            if (!empty($configuration) && $configuration->getDisableCustomerLogin()) {
                return true;
            }
        }

        return false;
    }

    public function login(Request $request)
    {
        $this->isWebsiteActive();

        if ($this->redirectUserToLogin()) {
            return $this->redirect($this->generateUrl('helpdesk_customer_ticket_collection')); // Replace with Dashboard route
        }

        /** check disabled customer login **/
        if($this->isLoginDisabled()) {
            $this->addFlash('warning', $this->get('translator')->trans('Warning ! Customer Login disabled by admin.') );
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }

        $session = $request->getSession();

        $error = $session->get(Security::AUTHENTICATION_ERROR);
        $session->remove(Security::AUTHENTICATION_ERROR);

        return $this->render('@UVDeskSupportCenter/Knowledgebase/login.html.twig', [
            'searchDisable' => true,
            'last_username' => $session->get(Security::LAST_USERNAME),
            'error'         => $error,
            'breadcrumbs' => [
                [
                    'label' => $this->get('translator')->trans('Support Center'),
                    'url' => $this->generateUrl('helpdesk_knowledgebase')
                ], [
                    'label' => $this->get('translator')->trans('Sign In'),
                    'url' => '#'
                ]
            ]
        ]);
    }

    public function Account(Request $request)
    {
        $this->isWebsiteActive();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $errors = [];

        if ($request->getMethod() == 'POST') {
            $data     = $request->request->all();
            $dataFiles = $request->files->get('user_form');
            $data = $data['user_form'];

            // Profile upload validation
            $validMimeType = ['image/jpeg', 'image/png', 'image/jpg'];
            if (isset($dataFiles['profileImage'])) {
                if (!in_array($dataFiles['profileImage']->getMimeType(), $validMimeType)) {
                    $this->addFlash('warning', $this->get('translator')->trans('Error ! Profile image is not valid, please upload a valid format'));
                    return $this->redirect($this->generateUrl('helpdesk_customer_account'));
                }
            }

            $checkUser = $em->getRepository('UVDeskCoreFrameworkBundle:User')->findOneBy(array('email'=>$data['email']));
            $errorFlag = 0;

            if ($checkUser) {
                if($checkUser->getId() != $user->getId())
                    $errorFlag = 1;
            }

            if (!$errorFlag) {
                $password = $user->getPassword();

                $form = $this->createForm(UserProfile::class, $user);
                $form->handleRequest($request);
                $form->submit($data);

                if ($form->isValid()) {
                    if ($data != null && (!empty($data['password']['first']))) {
                        $encodedPassword = $this->container->get('security.password_encoder')->encodePassword($user, $data['password']['first']);

                        if (!empty($encodedPassword) ) {
                            $user->setPassword($encodedPassword);
                        }
                    } else {
                        $user->setPassword($password);
                    }

                    $user->setFirstName($data['firstName']);
                    $user->setLastName($data['lastName']);
                    $user->setEmail($data['email']);
                    $user->setTimeZone($data['timezone']);
                    
                    $em->persist($user);
                    $em->flush();

                    $userInstance = $em->getRepository('UVDeskCoreFrameworkBundle:UserInstance')->findOneBy(array('user' => $user->getId()));

                    if (isset($dataFiles['profileImage'])) {
                        $assetDetails = $this->container->get('uvdesk.core.file_system.service')->getUploadManager()->uploadFile($dataFiles['profileImage'], 'profile');
                        $userInstance->setProfileImagePath($assetDetails['path']);
                    }

                    $userInstance  = $userInstance->setContactNumber($data['contactNumber']);
                    $em->persist($userInstance);
                    $em->flush();

                    $this->addFlash('success', $this->get('translator')->trans('Success ! Profile updated successfully.'));
                    return $this->redirect($this->generateUrl('helpdesk_customer_account'));
                } else {
                    $errors = $form->getErrors();
                    dump($errors);
                    die;
                    $errors = $this->getFormErrors($form);
                }
            } else {
                $this->addFlash('warning', $this->get('translator')->trans('Error ! User with same email is already exist.'));
                return $this->redirect($this->generateUrl('helpdesk_customer_account'));
            }
        }

        return $this->render('@UVDeskSupportCenter/Knowledgebase/customerAccount.html.twig', [
            'searchDisable' => true,
            'user' => $user,
        ]);
    }

    public function searchArticle(Request $request)
    {
        $this->isWebsiteActive();
        $searchQuery = $request->query->get('s');
        if (empty($searchQuery)) {
            return $this->redirect($this->generateUrl('helpdesk_customer_ticket_collection'));
        }

        $articleCollection = $this->getDoctrine()->getRepository('UVDeskSupportCenterBundle:Article')->getArticleBySearch($request);

        return $this->render('@UVDeskSupportCenter/Knowledgebase/search.html.twig', [
            'search' => $searchQuery,
            'articles' => $articleCollection,
            'breadcrumbs' => [
                ['label' => $this->get('translator')->trans('Support Center'), 'url' => $this->generateUrl('helpdesk_knowledgebase')],
                ['label' => $searchQuery, 'url' => '#'],
            ],
        ]);

    }

}
