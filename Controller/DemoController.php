<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use IDCI\Bundle\ContactFormBundle\Form\DemoMailerType;
use IDCI\Bundle\ContactFormBundle\Form\DemoSocialSharerType;

class DemoController extends Controller
{
    /**
     * @Route("/mail")
     * @Template("IDCIContactFormBundle:Demo:displayForm.html.twig")
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(new DemoMailerType());

        return array(
            'action' => $this->generateUrl('idci_contactform_api_contact', array(
                'mode' => 'mailer',
                'token' => '_demo_token'
            )),
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/social-share")
     * @Template("IDCIContactFormBundle:Demo:displayForm.html.twig")
     */
    public function socialShareAction(Request $request)
    {
        $form = $this->createForm(new DemoSocialSharerType());

        return array(
            'action' => $this->generateUrl('idci_contactform_api_contact', array(
                'mode' => 'social_sharer',
                'token' => '_demo_token'
            )),
            'form' => $form->createView()
        );
    }
}
