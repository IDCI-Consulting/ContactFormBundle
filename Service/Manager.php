<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\NoResultException;
use IDCI\Bundle\ContactFormBundle\Exception\ContactFormSourceUnavailableException;
use IDCI\Bundle\ContactFormBundle\Exception\ContactFormConfigurationException;
use IDCI\Bundle\ContactFormBundle\Exception\ContactFormSourceRequestException;
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
     * @throw ContactFormConfigurationException
     * @return boolean
     */
    public function checkConfiguration(Request $request)
    {
        if($this->getConfigurationParameter('https_only') && !$request->isSecure()) {
            throw new ContactFormConfigurationException("Request not valid: Https only");
        }

        if($this->getConfigurationParameter('restricted_method') != 'ANY') {
            if($request->getMethod() != $this->getConfigurationParameter('restricted_method')) {
                throw new ContactFormConfigurationException(sprintf(
                    "Request not valid: Http method %s expecting",
                    $this->getConfigurationParameter('restricted_method')
                ));
            }
        }

        return true;
    }

    /**
     * Check if the source exist and is valid
     *
     * @param Source $source
     * @param Request $request
     * @throw ContactFormRequestException
     * @return boolean
     */
    public function checkSourceRequest(Source $source, Request $request)
    {
        if($source->getHttpsOnly() && !$request->isSecure()) {
            throw new ContactFormSourceRequestException("Request not valid: Https only");
        }

        if($source->getHttpMethod() && $source->getHttpMethod() != $request->getMethod()) {
            throw new ContactFormSourceRequestException(sprintf("Request not valid: Http method %s expecting", $source->getHttpMethod()));
        }

        if($source->getDomainList() && !in_array($request->getHttpHost(), $source->getDomainList())) {
            throw new ContactFormSourceRequestException(sprintf("Request not valid: %s is not a valid domain", $request->getHttpHost()));
        }

        if($source->getIpWhiteList() && !in_array($request->getClientIp(), $source->getIpWhiteList())) {
            throw new ContactFormSourceRequestException(sprintf("Request not valid: %s is not in the ipWhiteList", $request->getClientIp()));
        }

        if($source->getIpBlackList() && in_array($request->getClientIp(), $source->getIpBlackList())) {
            throw new ContactFormSourceRequestException(sprintf("Request not valid: %s is in the ipBlackList", $request->getClientIp()));
        }

        return true;
    }

    /**
     * Retrieve the source based on the token
     *
     * @param string $token
     * @return Source
     */
    public function getSource($token)
    {
        try {
            $source = $this
                ->getEntityManager()
                ->getRepository('IDCIContactFormBundle:Source')
                ->getSource($token)
            ;
        } catch (NoResultException $e) {
            throw new ContactFormSourceUnavailableException();
        }

        return $source;
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
        $this->checkConfiguration($request);
        $this->checkSourceRequest($source, $request);

        if ($this->getConfigurationParameter('restricted_method') == 'GET') {
            return $request->query->all();
        }

        if ($this->getConfigurationParameter('restricted_method') == 'POST') {
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
        $providerService = $mode;
        if($mode == 'social_sharer') {
            var_dump($data);die;
        }

        return $this->getContainer()->get(sprintf(
            "idci_contactform.provider.%s",
            $providerService
        ));
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
