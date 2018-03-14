<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 10/01/2018
 * Time: 23:01
 */

namespace App\Controller;


use App\Form\TransactionType;
use App\Service\PriceAward;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TransactionRepository;
use App\Service\TransactionServices;
use Symfony\Component\HttpFoundation\Session\Session;
//use App\Service\TransactionForm;
//use App\Entity\Person;
//use App\Entity\Transaction;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;
//use App\Service\TransactionDataRecovery;
//use Doctrine\ORM\Entity;



class TransactionController extends Controller
{

    // formulaire ajout transaction + personnes
    public function addTransaction(PriceAward $priceAward, Request $request, Session $session,
                                   TransactionRepository $transactionRepository, TransactionServices $transactionServices)

    {
        // Récupération de la date de visite et nombre de personnes
        $nbPersons = $session->get('nbPersons');
        $visitDate = $session->get('visitDate');

        // Récupération des données de création de formulaire
        $transactionForm=$transactionServices->transactionFormCreation($visitDate, $nbPersons, $session);

        // Création du formulaire
        $form = $this->createForm(TransactionType::class, $transactionForm);
        $form->handleRequest($request);

        if ($form->isSubmitted()
            && $form->isValid()
        ) {

            $transaction = $transactionServices->transactionObjectCreation($visitDate, $nbPersons, $transactionForm,
                $transactionServices, $transactionRepository,  $session);

            $totalTransaction = 0;


            // Calcul du prix du billet selon anniversaire et réduction
            $persons = $transaction -> getPersons();
            foreach($persons as $uniquePerson2) {
                $placePrice = $priceAward->priceCalculation($uniquePerson2->getBirth(), $uniquePerson2->getReduction());
                $totalTransaction += $placePrice;
            }

            // Envoi de l'entité transaction et du montant de la commande dans la session
            $session->set('transaction', $transaction);
            $session->set('totalTransaction', $totalTransaction);


            // Affichage du récapitulatif de la commande
            return $this->render("transactionValidationRequest.html.twig", [
                    //'transactionId' => $transaction->getId(),
                    'transaction' => $transaction,
                    'totalTransaction' => $session->get('totalTransaction'),
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


}

