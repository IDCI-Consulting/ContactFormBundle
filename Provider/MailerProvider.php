<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Provider;

use IDCI\Bundle\ContactFormBundle\Entity\SourceProvider;

class MailerProvider extends AbstractProvider
{
    /**
     * Get mailer
     *
     * @return Mailer $mailer
     */
    public function getMailer()
    {
        return $this->getContainer()->get('mailer');
    }

    /**
     * Get templating
     *
     * @return Templating $templating
     */
    public function getTemplating()
    {
        return $this->getContainer()->get('templating');
    }

    public function sendMessage(SourceProvider $source_provider, $data)
    {
        var_dump($source_provider->getParameter('trest'));
        die;
        $message = \Swift_Message::newInstance()
            ->setSubject(sprintf(
                '[Contact Form - %s]',
                $source
            ))
            ->setFrom($source->getMail())
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderView(
                    'IDCIConstactFormBundle:ProviderMailer:body.txt.twig',
                    array('data' => $data)
                )
            )
        ;

        $this->getMailer()->send($message);
    }
}
