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


class PaymentStatusAction
{
    public function StripeError($status, \Swift_Mailer $mailer)
    {
        // Create a message
        $message = (new Swift_Message('Vos billets suite à votre commande'))
            ->setFrom(['sylviepil1l1@gmail.com' => 'Sylvie'])
            ->setTo(['sylviepil1l1@gmail.com' => 'Sylvie'])
            ->setBody('erreur');

        // Send the message
        $mailer->send($message);
    }


        public function __construct(\Swift_Mailer $mailer)
        {
            $this->mailer = $mailer;
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
    }

}
