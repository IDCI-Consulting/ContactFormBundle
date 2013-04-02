<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Provider;

use IDCI\Bundle\ContactFormBundle\Entity\Source;

class MailerProvider extends AbstractProvider
{
    protected $mailer;

    protected $templating;

    public function __construct($mailer, $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * Get mailer
     *
     * @return Mailer $mailer
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * Get templating
     *
     * @return Templating $templating
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    public function sendMessage(Source $source, $data)
    {
        var_dump($data); die;
        var_dump($this->getTemplating()->render(
                    'IDCIContactFormBundle:ProviderMailer:body.txt.twig',
                    array('data' => $data)
                ));die;
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
