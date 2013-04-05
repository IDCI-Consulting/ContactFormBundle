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
use IDCI\Bundle\ContactFormBundle\Entity\SourceProvider;

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
                    "Request not valid: Http method %s expected",
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
            throw new ContactFormSourceRequestException(sprintf("Request not valid: Http method %s expected", $source->getHttpMethod()));
        }

        $referer = parse_url($request->headers->get('referer'));
        if($source->getDomainList() && !in_array($referer['host'], $source->getDomainList())) {
            throw new ContactFormSourceRequestException(sprintf("Request not valid: %s is not a valid domain", $referer['host']));
        }

        if($source->getIpWhiteList() && !in_array($request->getClientIp(true), $source->getIpWhiteList())) {
            throw new ContactFormSourceRequestException(sprintf("Request not valid: %s is not in the ipWhiteList", $request->getClientIp(true)));
        }

        if($source->getIpBlackList() && in_array($request->getClientIp(true), $source->getIpBlackList())) {
            throw new ContactFormSourceRequestException(sprintf("Request not valid: %s is in the ipBlackList", $request->getClientIp(true)));
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
     * Notify a source that a new message was sent
     *
     * @param Source $source
     * @param Message $message
     */
    public function notify(SourceProvider $source_provider, Request $request)
    {
        $message = new Message();
        $message->setSource($source_provider->getSource());
        $message->setProvider($source_provider->getProvider());

        if($this->getConfigurationParameter('tracking_enabled')) {
            $message->setIp($request->getClientIp(true));
            $message->setHeaders($request->headers);
        }

        if($this->getConfigurationParameter('mode') != 'anonyme') {
            $data = $this->getRequestData($source_provider->getSource(), $request);
            $message->setData($data);
        }

        $em = $this->getEntityManager();
        $em->persist($message);
        $em->flush();
    }

    /**
     * Process the request with a given provider
     *
     * @param SourceProvider $source_provider
     * @param Request $request
     * @return array (ex: array("code"=> (int), "message" => (string)))
     */
    public function processRequest(SourceProvider $source_provider, Request $request)
    {
        try {
            $transformer = $this->getContainer()->get($source_provider->getDataRequestTransformer());
            $data = $transformer->transform($this->getRequestData(
                $source_provider->getSource(),
                $request
            ));

            // Send message
            $provider = $this->getContainer()->get($source_provider->getProvider());
            $provider->sendMessage($source_provider, $data);

            // Notify the source
            $this->notify($source_provider, $request);
        } catch(ContactFormConfigurationException $e) {
            return array(
                'code' => 451,
                'message' => $e->getMessage()
            );
        } catch(ContactFormSourceRequestException $e) {
            return array(
                'code' => 452,
                'message' => $e->getMessage()
            );
        } catch(ContactFormSourceUnavailableException $e) {
            return array(
                'code' => 453,
                'message' => $e->getMessage()
            );
        }

        return array(
            'code' => 200,
            'message' => 'OK'
        );
    }
}

