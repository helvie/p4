<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 10/01/2018
 * Time: 23:01
 */

namespace App\Controller;


use App\Entity\Transaction;
use App\Form\TransactionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Entity;
use Symfony\Component\HttpFoundation\Session\Session;


class HomeController extends Controller
{

    // Affichage page accueil (formulaire date visite + nombre personnes)
    public function homeDisplay(Request $request, Session $session)
    {
        // Remise à zéro session
        $session->remove('transaction');
        $session->remove('totalTransaction');


        // Création d'un formulaire avec l'entité transaction
        $transaction = new transaction();

        $form = $this->createForm(TransactionType::class, $transaction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupération des données du formulaire
            $transactionData = $form->getData();

            // Enregistrement de la date de visite et nb personnes dans la session
            $session->set('nbPersons', $transactionData->getNbPersons());
            $session->set('visitDate', $transactionData->getVisitDate());

            // Redirection sur le la création du reste du formulaire transacttion + personnes
            return $this->redirectToRoute("formTransaction");
        }
        // Affichage de la page d'accueil
        return $this->render('homePage.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
