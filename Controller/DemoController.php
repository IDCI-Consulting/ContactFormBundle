<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @ licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use IDCI\Bundle\ContactFormBundle\Form\DemoMailerType;
use IDCI\Bundle\ContactFormBundle\Form\DemoSocialSharerType;

/**
 * Message controller.
 *
 * @Route("/contact/demo")
 */
class DemoController extends Controller
{
    /**
     * @Route("/mail", name="contact_demo_mail")
     * @Template("IDCIContactFormBundle:Demo:displayForm.html.twig")
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(new DemoMailerType());

        return array(
            'action' => $this->generateUrl('idci_contactform_api_contact', array(
                'token' => '_demo_token'
            )),
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/social-share", name="contact_demo_socialshare")
     * @Template("IDCIContactFormBundle:Demo:displayForm.html.twig")
     */
    public function socialShareAction(Request $request)
    {
        $form = $this->createForm(new DemoSocialSharerType());

        return array(
            'action' => $this->generateUrl('idci_contactform_api_contact', array(
                'token' => '_demo_token'
            )),
            'form' => $form->createView()
        );
    }
}
