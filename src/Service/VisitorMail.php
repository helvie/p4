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
use \Twig_Environment;


class VisitorMail
{



    private $templating;

    public function __construct(\Twig_Environment $templating)
    {
        $this->templating = $templating;
    }

    public function visitorMail($recipient, $session)
    {

        $message = (new Swift_Message('Vos billets suite à votre commande'))
            ->setFrom(['sylvie@helvie.fr' => 'Sylvie'])
            ->setTo([$recipient => "Internaute"])
            ->setBody($this->templating->render(
            'mail\mailTransaction.html.twig',
                array(
                'transaction' => $session->get('transaction'),
                'totalTransaction' => $session->get('totalTransaction'),
                )
            ),
            'text/html'
            );


        return ($message);

    }

}




