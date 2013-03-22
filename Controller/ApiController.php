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
     * @Route("/{mode}/{token}")
     * @Template()
     */
    public function contactAction(Request $request, $mode, $token)
    {
        // Retrieve the source
        $source = $this->get('idci_contactform.manager')->getSource($token);

        // Retreive request data as defined in the config.yml
        $data = $this->get('idci_contactform.manager')->getRequestData($source, $request);

        // Get the right provider 
        $provider = $this->get('idci_contactform.manager')->getProvider($mode);

        // send message
        $provider->sendMessage($data);

        // Notify the source
        $this->get('idci_contactform.manager')->notify($source, $request);

        $source = $request->getHttpHost();
        var_dump($request->isSecure());
        var_dump($request->getClientIp());


        //var_dump($request);die;
        var_dump($request->getQueryString());
        var_dump($request->getMethod());
        var_dump($request->getRequestFormat());

        // Todo: View return content html, json or xml ?
        var_dump($request->isXmlHttpRequest());
        //var_dump($request->);
        die;
        return array();
    }
}
