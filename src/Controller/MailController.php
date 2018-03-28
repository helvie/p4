<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 17/03/2018
 * Time: 13:08
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Service\VisitorMail;
use Swift_Mailer;
use Swift_Message;

class MailController extends Controller
{

    function visitorMailSend(Session $session, \Swift_Mailer $mailer, VisitorMail $visitorMail)
    {


    // Récupération de l'email du passeur de commande et création du mail via Swiftmail
    $recipient = $session->get('transaction')->getEmail();

    $message = $visitorMail->visitorMail($recipient, $session);

    // Send the message
    $mailer->send($message);


        // Affichege de la page récapitulative de la commande
        return $this->render("validatedTransaction.html.twig",
            array(
                'transaction' => $session->get('transaction'),
                'totalTransaction' => $session->get('totalTransaction'),
            )
        );

    }
}



