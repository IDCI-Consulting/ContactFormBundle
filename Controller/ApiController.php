<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
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

        foreach($source->getSourceProviders() as $sourceProvider) {
            $this->get('idci_contactform.manager')->processRequest($sourceProvider, $request);
        }

        // Todo: View return content html, json or xml ?
        var_dump($request->isXmlHttpRequest());
        //var_dump($request->);
        die('good');
    }
}
