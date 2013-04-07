<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @ licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ApiController extends Controller
{
    /**
     * @Route("/{token}")
     * @Template()
     */
    public function contactAction(Request $request, $token)
    {
        // Retrieve the source
        $source = $this->get('idci_contactform.manager')->getSource($token);

        $responses = array();
        foreach($source->getSourceProviders() as $sourceProvider) {
            $responses[] = $this->get('idci_contactform.manager')->processRequest($sourceProvider, $request);
        }

        $response = new Response();
        $response->setContent($this->renderView(
            sprintf(
                "IDCIContactFormBundle:Api:response.%s.twig",
                $source->getResponseFormat()
            ),
            array('responses' => $responses)
        ));
        $response->headers->set('Content-Type', $source->getResponseContentType());

        return $response;
    }
}
