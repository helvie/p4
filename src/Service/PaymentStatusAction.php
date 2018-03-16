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

    // Envoi d'un mail à l'administrateur du site en cas d'erreur du paiement Stripe dans le site internet
    public function StripeError($error)
    {
        $messageError = "L'erreur suivante s'est produite :".$error;

        // Create a message
        $message = (new Swift_Message("Une erreur s'est produite lors d'une commande"))
            ->setFrom(['sylvie@hevie.fr' => 'Sylvie'])
            ->setTo(['sylviepil1l1@gmail.com' => 'Sylvie'])
            ->setBody($messageError);

        // Send the message
        $this->mailer->send($message);

        $this->session->set('paymentError', 'stripeError');

    }


    // Envoi d'un mail à l'administrateur du site en cas d'erreur du paiement Stripe au niveau de la banque
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




