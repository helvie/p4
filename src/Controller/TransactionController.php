<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 10/01/2018
 * Time: 23:01
 */

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
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


use App\Repository\PersonRepository;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Service\TransactionDataRecovery;
use App\Repository\TransactionRepository;





class TransactionController extends Controller
{

// formulaire ajout transaction + personnes
    public function addTransaction(PriceAward $priceAward, Request $request, SessionInterface $session, TransactionRepository $transactionRepository)

    {
        // Récupération de la date de visite et nombre de personnes
        $nbPersons = $session->get('nbPersons');
        $visitDate = $session->get('visitDate');

        // Création du formulaire avec entité transaction en y injectant la date de visite et nombre personnes
        $transactionForm = new Transaction();
        $transactionForm->setVisitDate($visitDate);
        $transactionForm->setNbPersons($nbPersons);

        // Si l'entité transaction a déjà été créée, récup des informations pour les injecter dans les formulaire de modification
        if ($session->get('transaction') != '') {
            $transactionForm->setEmail($session->get('transaction')->getEmail());
            $transactionForm->setHalfDay($session->get('transaction')->getHalfDay());

            foreach ($session->get('transaction')->getPersons() as $personData) {

                $person = new Person();
                $person->setName($personData->getName());
                $person->setFirstName($personData->getFirstName());
                $person->setCountry($personData->getCountry());
                $person->setBirth($personData->getBirth());
                $person->setReduction($personData->getReduction());
                $transactionForm->getPersons()->add($person);
            }

            // Sinon, création d'entités personnes injectées dans transaction selon nombre visiteurs
        } else {
            for ($i = 0; $i < $nbPersons; $i++) {
                $person = new person();
                $transactionForm->getPersons()->add($person);
            }

        }

        // Création du formulaire
        $form = $this->createForm(TransactionType::class, $transactionForm);
        $form->handleRequest($request);

        if ($form->isSubmitted()
            //&& $form->isValid()
        ) {

            // Création d'une entité transaction pour préparer les données de BD
            $transaction = new Transaction();

            // Récupération des personnes dans les données formulaire
            $personsList = $transactionForm->getPersons();

            // Affichage de la case à cocher si la date de visite n'est pas le jour même après 14h
            $dateNow = new \DateTime('now');
            if ($dateNow->format('y-m-d') == $visitDate->format('y-m-d') && $dateNow->format("H") > 13) {
                $transaction->setHalfDay(true);
            } else {
                $transaction->setHalfDay($transactionForm->getHalfDay());
            }

            // Injection des données dans l'entité transaction
            $transaction->setEmail(mb_strtolower($transactionForm->getEmail()));
            $transaction->setVisitDate($visitDate);
            $transaction->setNbPersons($nbPersons);
            $transaction->setTransactionCode("essai");

            // Création variable du montant de la commande
            $totalTransaction = 0;

            // Récupération des persomnes dans les données formulaire
            foreach ($personsList as $uniquePerson) {
                $person = new Person();
                //$str = mb_strtoupper($uniquePerson->getName(), 'UTF-8');

                $person->setName(mb_strtoupper($uniquePerson->getName(), 'UTF-8'));
                $person->setFirstName(mb_strtoupper($uniquePerson->getFirstName(), 'UTF-8'));
                $person->setCountry(mb_strtoupper($uniquePerson->getCountry(), 'UTF-8'));
                $person->setBirth($uniquePerson->getBirth());
                $person->setReduction($uniquePerson->getReduction());
                $person->setTransaction($transaction);

                // Injection de chaque personne dans l'array persons de l'entité transaction
                $transaction->getPersons()->add($person);

                // Calcul du prix du billet selon anniversaire et réduction
                $price = $priceAward->priceCalculation($uniquePerson->getBirth(), $uniquePerson->getReduction());

                // Ajout du prix du billet au montant total de la commande
                $totalTransaction += $price;
            }


            $year = $visitDate->format('y');
            $month = $visitDate->format('m');
            $day = $visitDate->format('d');
            $applicant = $transaction->getpersons()->first()->getName();
            $applicantCode = substr($applicant . "000", 0, 4);
            $prout = $applicantCode . $year . $month . $day;

            $transactionCodeZ = $transactionRepository->findTransactionsByTransactionCode($prout);
            $plus=max($transactionCodeZ);
            //if (empty($transactionCodeZ)) {
             //   $transactionCodeB = $transactionCode . "00";
            //} else {
                //$transactionCodeB = max($transactionCodeZ);
            //}




        // Envoi de l'entité transaction et du montant de la commande dans la session
        $session->set('transaction', $transaction);
        $session->set('totalTransaction', $totalTransaction);


        // Affichage du récapitulatif de la commande
        return $this->render("transactionValidationRequest.html.twig", [
                //'transactionId' => $transaction->getId(),
                'transaction' => $transaction,
                'totalTransaction' => $totalTransaction,
                'chaine' => $plus,
                'chaine2' =>$transactionCodeZ
            ]
        );
        };

        // Affichage du formulaire de transaction
        return $this->render("transaction.html.twig", array(
                'form' => $form->createView(),
                'transactionId' => $request->get('transactionId')
            )
        );

    }


    public function transactionFinalization(PriceAward $priceAward, Request $request, SessionInterface $session, \Swift_Mailer $mailer)
    {
        /* Create the Transport
$transport = (new Swift_SmtpTransport('smtp.example.org', 25))
    ->setUsername('your username')
    ->setPassword('your password')
;

// Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);*/

        // Create a message
        $message = (new Swift_Message('Vos billets suite à votre commande'))
            ->setFrom(['sylviepil1l1@gmail.com' => 'Sylvie'])
            ->setTo([$session->get('transaction')->getEmail()])
            ->setBody('Renvoi vers page twig');

        // Send the message
        $result = $mailer->send($message);


        return $this->render("validatedTransaction.html.twig", array(
            'transactionData' => $transactionData,
            'transactionAmount' => $transactionAmount,
            'essai' => $transactionData[0]['transaction']->getEmail(),
            'transactionId' => $request->get('transactionId'),
            'essaiTransac' => $essaiTransac

        ));
    }


}

