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

            // Initialisation des variables pour le montant total de la commande et l'âge du visiteur le plus âgé
            $totalTransaction = 0;
            $maxAge = 0;


            // Calcul du prix du billet selon anniversaire et réduction
            $persons = $transaction -> getPersons();
            foreach($persons as $uniquePerson2) {
                $ageCalculation = $priceAward->ageCalculation($uniquePerson2->getBirth());
                $placePrice = $priceAward->priceCalculation($ageCalculation, $uniquePerson2->getReduction());

                // Ajout du prix de la place au montant total de la transaction
                $totalTransaction += $placePrice;

                // Si la personne est la plus âgée, attribution de la valeur à la variable age maxi
                if($ageCalculation > $maxAge){
                    $maxAge = $ageCalculation;
                }
            }



            // Si le visiteur le plus âgé a moins de 14 ans, réaffichage du formulaire pour modification
            if($maxAge < 14){
                // Affichage du formulaire de transaction
                return $this->render("transaction.html.twig", array(
                        'form' => $form->createView(),
                        'transactionId' => $request->get('transactionId'),
                        'maxPrice' => $session->get('maxPrice'),

                    )
                );
            }
            else {


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
            }
        };

        // Affichage du formulaire de transaction
        return $this->render("transaction.html.twig", array(
                'form' => $form->createView(),
                'transactionId' => $request->get('transactionId'),
            )
        );

    }


}

