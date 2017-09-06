<?php
/**
 * Created by PhpStorm.
 * User: fredd
 * Date: 25/01/2017
 * Time: 08:38
 */

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Emails
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function sendActivation($emailTo, $emailFrom, $name, $active_hash)
    {
        $email = '';
        if(!empty($emailFrom)){
            $email .= $emailFrom;
        } else{
            $email .= 'noreply@noreply.com';
        }
        $message = \Swift_Message::newInstance()
            ->setSubject('Activate Account')
            ->setFrom($email)
            ->setTo($emailTo)
            ->setBody(
                $this->container->get('templating')->render(
                    $this->container->getParameter('theme_name').'/emails/registration.html.twig',
                    ['name' => $name, 'active_hash'=> $active_hash] ),
                'text/html'
            );

        $this->container->get('mailer')->send($message);
    }

    public function sendResetPasswordLink($emailTo, $emailFrom, $name, $token)
    {
        $email = '';
        if(!empty($emailFrom)){
            $email .= $emailFrom;
        } else{
            $email .= 'noreply@noreply.com';
        }
        $message = \Swift_Message::newInstance()
            ->setSubject('Reset Password')
            ->setFrom($email)
            ->setTo($emailTo)
            ->setBody(
                $this->container->get('templating')->render(
                    $this->container->getParameter('theme_name').'/emails/reset_link.html.twig',
                    ['name' => $name, 'token'=> $token] ),
                'text/html'
            );

        $this->container->get('mailer')->send($message);
    }

}