<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Provider;

use IDCI\Bundle\ContactFormBundle\Entity\Source;

abstract class AbstractProvider
{
    /**
     * Send message using data
     *
     * @param Source $source
     * @param array $data
     * @return boolean
     */
    abstract function sendMessage(Source $source, $data);
}
