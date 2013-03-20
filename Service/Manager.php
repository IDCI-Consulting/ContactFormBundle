<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use IDCI\Bundle\ContactFormBundle\Exception\NotReceivableRequestException;
use IDCI\Bundle\ContactFormBundle\Exception\NotValidSourceException;
use IDCI\Bundle\ContactFormBundle\Entity\Source;
use IDCI\Bundle\ContactFormBundle\Entity\Message;

class Manager
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Get the container
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Get the entity manager
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * Get the configuration
     *
     * @return array
     */
    public function getConfiguration()
    {
        return $this->getContainer()->getParameter('contactFormConfiguration');
    }

    /**
     * Get configuration parameter
     *
     * @return mixed
     */
    public function getConfigurationParameter($name)
    {
        $configuration = $this->getConfiguration();

        return $configuration[$name];
    }

    /**
     * Check the validity of the request as defined in the configuration
     *
     * @param Request $request
     */
    public function isReceivableRequest(Request $request)
    {
        if($this->getConfigurationParameter('https_only')) {
            return $request->isSecure();
        }

        if($this->getConfigurationParameter('restricted_method') != 'ANY') {
            return $request->getMethod() == $this->getConfigurationParameter('restricted_method');
        }

        return true;
    }

    /**
     * Check if the source exist and is valid
     *
     * @param Source $source
     * @param Request $request
     * @return boolean
     */
    public function isValidSource(Source $source, Request $request)
    {
        //if($source->get)
        // Compare the request with source preferences
          // domainListe
          // ipWhiteListe
          // ipBlackListe
          // httpsOnly
          // methodPostOnly
          // methodGetOnly

        return false;
    }

    /**
     * Retrieve the source based on the token
     *
     * @param string $token
     * @return Source
     */
    public function getSource($token)
    {
        return $this->getEntityManager()->getRepository('IDCIContactFormBundle:Source')->getSource($token);
    }

    /**
     * Retrieve data from the request as defined in the configuration
     *
     * @param Source $source
     * @param Request $request
     * @return array
     */
    public function getRequestData(Source $source, Request $request)
    {
        if(!$this->isReceivableRequest($request)) {
            throw new NotReceivableRequestException();
        }

        if(!$this->isValidSource($source, $request)) {
            throw new NotValidSourceException();
        }

        if ($this->getConfiguration('method_get_only')) {
            return $request->query->all();
        }

        if ($this->getConfiguration('method_post_only')) {
            return $request->request->all();
        }

        return $data = array_merge(
            $request->query->all(),
            $request->request->all()
        );
    }

    /**
     * Retrieve a provider based on a given mode
     *
     * @param string $mode
     * @param array $data
     */
    public function getProvider($mode, $data = null)
    {

    }

    /**
     * Notify a source that a new message was sent
     *
     * @param Source $source
     * @param Message $message
     */
    public function notify(Source $source, Message $message)
    {
    }

    /**
     *
     */
    public function processRequest(Request $request)
    {
        // Objéctif: request -> message ()

        // 
        return $this;
    }
}
