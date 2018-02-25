<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 10/01/2018
 * Time: 23:01
 */

namespace App\Controller;

use App\Entity\Person;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Service\PriceAward;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Entity;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Swift_Mailer;
use Swift_Message;
use DateTime;
use DateInterval;
use Doctrine\Common\Collections\ArrayCollection;
use Stripe\Stripe;
use App\Service\PaymentStatusAction;



class PaymentController extends Controller
{
    public function cardNumber(Request $request)
    {
        return $this->render('cardNumber.html.twig');
    }


    public function validPayment(Request $request, Session $session, PaymentStatusAction $paymentStatusAction, \Swift_Mailer $mailer)
    {
        \Stripe\Stripe::setApiKey("sk_test_judrLeNL04PWjxhBfhzH4ZpV");

        //require_once('vendor/autoload.php');

        try {
        \Stripe\Charge::create(array(
            "amount" => ($session->get('totalTransaction')) * 100,
            "currency" => "eur",
            "source" => $request->request->get('stripeToken'), // obtained with Stripe.js
            "description" => "Paiement test"
        ));

            // Accès à la base de données, récupération de l'entité transaction,
            // envoi en BDD (PROVISOIRE sera mis après vérif paiement)
            $message = "ok";
            $em = $this->getDoctrine()->getManager();
            $transaction = $session->get('transaction');

            $em->persist($transaction);
            $em->flush();


        } catch (\Stripe\Error\ApiConnection $e) {
        // Network problem, perhaps try again.
            $message="apiconnection";
        }

        catch (\Stripe\Error\InvalidRequest $e) {
        // You screwed up in your programming. Shouldn't happen!
            $message="invalidrequest";

        }

        catch (\Stripe\Error\Api $e) {
        // Stripe's servers are down!
            $message="apitoutcourt";

        }

        catch (\Stripe\Error\Authentication $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
            $message="authentification";

        }

        catch (\Stripe\Error\Base $e) {
            // Something else happened, completely unrelated to Stripe
            $paymentStatusAction->CardError();
        // Display a very generic error to the user, and maybe send
        // yourself an email
            $message="base";

        }

        catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
            $paymentStatusAction->CardError();
            $message="c'est raté";
        }


        return $this->render("validatedTransaction.html.twig",
            array(
                //'transactionId' => $transaction->getId(),
                'transaction' => $session->get('transaction'),
                'totalTransaction' => $session->get('totalTransaction'),
                'message' => $message,
            )
        );
    }

}