<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Provider;

use IDCI\Bundle\ContactFormBundle\Entity\SourceProvider;

class SocialSharerProvider extends AbstractProvider
{
    public function sendMessage(SourceProvider $sourceProvider, $data)
    {
        var_dump($data);die;
    }
}
