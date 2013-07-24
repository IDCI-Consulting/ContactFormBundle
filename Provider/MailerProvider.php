<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
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

    public function sendMessage(SourceProvider $sourceProvider, $data)
    {
        $mailerTransport = $sourceProvider->getParameter(
            'mailer_transport',
            $this->getContainer()->getParameter('mailer_transport')
        );

        $mailerHost = $sourceProvider->getParameter(
            'mailer_host',
            $this->getContainer()->getParameter('mailer_host')
        );

        $mailerPort = $sourceProvider->getParameter(
            'mailer_port',
            $this->getContainer()->hasParameter('mailer_port')
            ? $this->getContainer()->getParameter('mailer_port')
            : 25
        );

        $mailerUser = $sourceProvider->getParameter(
            'mailer_user',
            $this->getContainer()->getParameter('mailer_user')
        );

        $mailerPassword = $sourceProvider->getParameter(
            'mailer_password',
            $this->getContainer()->getParameter('mailer_password')
        );

        $mailerEncryption = $sourceProvider->getParameter('mailer_encryption');

        $subject = $sourceProvider->getParameter('subject');
        $to = $sourceProvider->getParameters('to');
        $cc = $sourceProvider->getParameters('cc');
        $bcc = $sourceProvider->getParameters('bcc');

        if ($mailerTransport == 'smtp') {
            $transport = \Swift_SmtpTransport::newInstance($mailerHost, $mailerPort, $mailerEncryption)
                ->setUsername($mailerUser)
                ->setPassword($mailerPassword)
            ;
        }

        /*
        You could alternatively use a different transport such as Sendmail or Mail:

        // Sendmail
        $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

        // Mail
        $transport = Swift_MailTransport::newInstance();
        */

        // Create the Mailer using your created Transport
        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance()
            ->setSubject(sprintf(
                '[Contact Form] - %s',
                $subject
            ))
            ->setTo($to)
            ->setCc($cc)
            ->setBcc($bcc)
            ->setFrom($sourceProvider->getSource()->getMail())
            ->setBody(
                $this->getTemplating()->render(
                    'IDCIContactFormBundle:ProviderMailer:body.txt.twig',
                    array('data' => $data)
                )
            )
        ;

        $mailer->send($message);
    }
}
