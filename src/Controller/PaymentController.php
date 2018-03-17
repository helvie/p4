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
use Symfony\Component\HttpFoundation\Session\Session;
use Swift_Message;

use App\Service\PaymentStatusAction;
use App\Service\VisitorMail;
use Doctrine\ORM\Entity;
use Stripe\Stripe;


class PaymentController extends Controller
{

    public function cardNumber(Request $request)
    {
        return $this->render('cardNumber.html.twig');
    }


    public function validPayment(Session $session, PaymentStatusAction $paymentStatusAction,
                                 \Swift_Mailer $mailer, Request $request, VisitorMail $visitorMail)
    {

        // Module de paiement stripe
        \Stripe\Stripe::setApiKey("sk_test_judrLeNL04PWjxhBfhzH4ZpV");

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


             // Si ok, injection de l'entité transaction dans la BDD
             $em->persist($transaction);
             $em->flush();

             // Récupération de l'email du passeur de commande et création du mail via Swiftmail
             $recipient = $session->get('transaction')->getEmail();
             $message = $visitorMail->visitorMail($recipient, $session);
             // Send the message
             $mailer->send($message);

             // Affichage de la page récapitulative de la commande
             return $this->render("validatedTransaction.html.twig",
                 array(
                     //'transactionId' => $transaction->getId(),
                     'transaction' => $session->get('transaction'),
                     'totalTransaction' => $session->get('totalTransaction'),
                 )
             );

             // En cas d'erreur, autre que la carte de paiement, récupération de l'erreur et envoi d'un mail au développeur
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
         // Affichage de la page de coordonnées de carte bancaire
         return $this->render("cardNumber.html.twig",
             array(
                 'transaction' => $session->get('transaction'),
                 'totalTransaction' => $session->get('totalTransaction'),
                 'paymentError' => $session->get('paymentError'),
             )
         );

    }
}

;



