<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 07/03/2018
 * Time: 21:26
 */

namespace App\Service;

use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Transaction;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Person;
//use App\Service\PriceAward;




class TransactionServices
{
    public function transactionCodeCreation(TransactionRepository $transactionRepository, SessionInterface $session, $transaction){

        $visitDate = $session->get('visitDate');
        // Création code commande 4 premiers caractères nom + année mois jour visite + nombre à deux chiffres
        $year = $visitDate->format('y');
        $month = $visitDate->format('m');
        $day = $visitDate->format('d');
        $applicantName = $transaction->getpersons()->first()->getName();
        $applicantNameDebut = substr($applicantName . "AAA", 0, 4);
        $transactionCodeDebut = $applicantNameDebut . $year . $month . $day;

        // Récupération dans la BDD des codes avec le même début
        $transactionCodeTable = $transactionRepository->findTransactionsByTransactionCode($transactionCodeDebut);

        // S'il n'y en a pas la fin du code est "00"
        if (empty($transactionCodeTable)) {
            $finalTransactionCode = $transactionCodeDebut . "00";

            // sinon récup des deux derniers chiffre du plus haut code et ajout d'une unité
        } else {
            $transactionCodeMaxi = substr(max($transactionCodeTable)['transactionCode'], -2);

            // Si inférieur à 9 le code est "0" + chiffre trouvé
            if ($transactionCodeMaxi < 9) {
                $finalTransactionCode = $transactionCodeDebut . "0" . ($transactionCodeMaxi + 1);
                // Sinon c'est directement le nombre
            } else {
                $finalTransactionCode = $transactionCodeDebut . ($transactionCodeMaxi + 1);
            }
        }

        return($finalTransactionCode);

    }


    public function transactionFormCreation($visitDate, $nbPersons,  Session $session){
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

        return($transactionForm);

    }



    public function transactionObjectCreation($visitDate, $nbPersons, $transactionForm, TransactionServices $transactionServices,
                                              TransactionRepository $transactionRepository, SessionInterface $session){

        // Création d'une entité transaction pour préparer les données de BD
        $transaction1 = new Transaction();

        // Récupération des personnes dans les données formulaire
        $personsList = $transactionForm->getPersons();

        // Si la date de visite est le jour même après 14h met la demi-journée à "true", sinon récupère donnée du formulaire
        $dateNow = new \DateTime('now');
        if ($dateNow->format('y-m-d') == $visitDate->format('y-m-d') && $dateNow->format("H") > 13) {
            $transaction1->setHalfDay(true);
        }
        else
        {

            $transaction1->setHalfDay($transactionForm->getHalfDay());
        }

        // Injection des données dans l'entité transaction
        $transaction1->setEmail(mb_strtolower($transactionForm->getEmail()));
        $transaction1->setVisitDate($visitDate);
        $transaction1->setNbPersons($nbPersons);

        // Création variable du montant de la commande
        //$totalTransaction = 0;

        // Récupération des persomnes dans les données formulaire
        foreach ($personsList as $uniquePerson) {
            $person = new Person();
            $person->setName(mb_strtoupper($uniquePerson->getName(), 'UTF-8'));
            $person->setFirstName(mb_strtoupper($uniquePerson->getFirstName(), 'UTF-8'));
            $person->setCountry(mb_strtoupper($uniquePerson->getCountry(), 'UTF-8'));
            $person->setBirth($uniquePerson->getBirth());
            $person->setReduction($uniquePerson->getReduction());
            $person->setTransaction($transaction1);

            // Injection de chaque personne dans l'array persons de l'entité transaction
            $transaction1->getPersons()->add($person);
        }

        // Récupération du code de la transaction créé et injection dans $transaction
        $finalTransactionCode = $transactionServices->transactionCodeCreation($transactionRepository, $session, $transaction1);
        $transaction1->setTransactionCode($finalTransactionCode);

        return($transaction1);

    }


}