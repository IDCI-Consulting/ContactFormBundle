<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Provider;

use IDCI\Bundle\ContactFormBundle\Entity\SourceProvider;

abstract class AbstractProvider
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Send message using data
     *
     * @param SourceProvider $source
     * @param array $data
     * @return boolean
     */
    abstract function sendMessage(SourceProvider $source_provider, $data);
}
