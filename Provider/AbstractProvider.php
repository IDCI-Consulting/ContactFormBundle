<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Provider;

abstract class AbstractProvider
{
    /**
     * Send message using data
     *
     * @param array $data
     * @return boolean
     */
    abstract function sendMessage($data);
}
