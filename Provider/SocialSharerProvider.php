<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Provider;

use IDCI\Bundle\ContactFormBundle\Entity\Source;

class SocialSharerProvider extends AbstractProvider
{
    public function sendMessage(Source $source, $data)
    {
        var_dump($data);die;
    }
}
