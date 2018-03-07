<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 10/01/2018
 * Time: 23:01
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Entity;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Swift_Mailer;
use Swift_Message;

use Stripe\Stripe;
use App\Service\PaymentStatusAction;
use Swift_SmtpTransport;


class PaymentController extends Controller
{
    public function cardNumber(Request $request)
    {
        return $this->render('cardNumber.html.twig');
    }

    public function validPayment(Request $request, Session $session, PaymentStatusAction $paymentStatusAction,
                                 \Swift_Mailer $mailer)
    {

        // Create the Transport
        $transport = (new Swift_SmtpTransport('auth.smtp.1and1.fr', 587))
            ->setUsername('sylvie@hevie.fr')
            ->setPassword('onOrange4201*');

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        $recipient = $session->get('transaction')->getEmail();

        // Create a message
        $message = (new Swift_Message('Vos billets suite à votre commande'))
            ->setFrom(['sylvie@hevie.fr' => 'Sylvie'])
            ->setTo([$recipient => 'Sylvie'])
            ->setBody($this->renderView(
                'mail\mailTransaction.html.twig',
                array(
                    //'transactionId' => $transaction->getId(),
                    'transaction' => $session->get('transaction'),
                    'totalTransaction' => $session->get('totalTransaction'),
                )
            ),
                'text/html'
            );

        // Send the message
        $mailer->send($message);

        return $this->render("validatedTransaction.html.twig",
            array(
                'transaction' => $session->get('transaction'),
                'totalTransaction' => $session->get('totalTransaction'),
                'paymentError' => $session->get('paymentError'),
            )
        );


        /* \Stripe\Stripe::setApiKey("sk_test_judrLeNL04PWjxhBfhzH4ZpV");

         //require_once('vendor/autoload.php');

         try {
             \Stripe\Charge::create(array(
                 "amount" => ($session->get('totalTransaction')) * 100,
                 "currency" => "eur",
                 "source" => $request->request->get('stripeToken'), // obtained with Stripe.js
                 "description" => "Paiement test"
             ));

             // Accès à la base de données, récupération de l'entité transaction,
             $em = $this->getDoctrine()->getManager();
             $transaction = $session->get('transaction');

             $em->persist($transaction);
             $em->flush();


             $recipient = $session->get('transaction')->getEmail();

             // Create a message
             $message = (new Swift_Message('Vos billets suite à votre commande'))
                 ->setFrom(['sylvie@hevie.fr' => 'Sylvie'])
                 ->setTo([$recipient => 'Sylvie'])
                 ->setBody($this->renderView(
                     'mail\mailTransaction.html.twig',
                     array(
                         //'transactionId' => $transaction->getId(),
                         'transaction' => $session->get('transaction'),
                         'totalTransaction' => $session->get('totalTransaction'),
                     )
                 ),
                     'text/html'
                 );

             // Send the message
             $mailer->send($message);


             return $this->render("validatedTransaction.html.twig",
                 array(
                     //'transactionId' => $transaction->getId(),
                     'transaction' => $session->get('transaction'),
                     'totalTransaction' => $session->get('totalTransaction'),
                 )
             );

         } catch (\Stripe\Error\ApiConnection $e) {
             $paymentStatusAction->StripeError("apiConnection");
         } catch (\Stripe\Error\InvalidRequest $e) {
             $paymentStatusAction->StripeError("invalidRequest");
         } catch (\Stripe\Error\Api $e) {
             $paymentStatusAction->StripeError("api");
         } catch (\Stripe\Error\Authentication $e) {
             $paymentStatusAction->StripeError("authentification");
         } catch (\Stripe\Error\Base $e) {
             $paymentStatusAction->CardError();
         } catch (Exception $e) {
             $paymentStatusAction->CardError();
         }

         return $this->render("cardNumber.html.twig",
             array(
                 'transaction' => $session->get('transaction'),
                 'totalTransaction' => $session->get('totalTransaction'),
                 'paymentError' => $session->get('paymentError'),
             )
         );*/

    }
}

;



