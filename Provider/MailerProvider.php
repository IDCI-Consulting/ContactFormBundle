<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Provider;

class MailerProvider extends AbstractProvider
{
    protected $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
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

    public function sendMessage($data)
    {
        var_dump($data);die;
    }
}
