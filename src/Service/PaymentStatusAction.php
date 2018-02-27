<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 10/01/2018
 * Time: 23:01
 */

namespace App\Service;


use Doctrine\ORM\Entity;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class PaymentStatusAction
{


    public function __construct(\Swift_Mailer $mailer, SessionInterface $session)
    {
        $this->mailer = $mailer;
        $this->session = $session;
    }


    public function StripeError($error)
    {
        $messageError = $error;

        // Create a message
        $message = (new Swift_Message('Vos billets suite à votre commande'))
            ->setFrom(['sylviepil1l1@gmail.com' => 'Sylvie'])
            ->setTo(['sylviepil1l1@gmail.com' => 'Sylvie'])
            ->setBody($messageError);

        // Send the message
        $this->mailer->send($message);

        $this->session->set('paymentError', 'stripeError');

    }


    public function CardError()
    {
        // Create a message
        $message = (new Swift_Message('Vos billets suite à votre commande'))
            ->setFrom(['sylviepil1l1@gmail.com' => 'Sylvie'])
            ->setTo(['sylviepil1l1@gmail.com' => 'Sylvie'])
            ->setBody('erreur');

        // Send the message
        $this->mailer->send($message);

        $this->session->set('paymentError', 'cardError');


    }

}




