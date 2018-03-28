<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use DateTime;
use App\Service\PriceAward;
use Twig_Extension;

class AppExtension extends \Twig_Extension
{

    private $priceAward;

    public function __construct(PriceAward $priceAward)
    {
        $this->priceAward = $priceAward;
    }

    public function getFunctions()
    {
        return array(
            'ageCalculation' => new \Twig_Function('ageCalculation', array($this, 'ageCalculation')),
            'priceCalculation' => new \Twig_Function('priceCalculation', array($this, 'priceCalculation')),

        );
    }
    // Fonction calcul de l'âge du visiteur, en récupérant le service "calcul d'âge"
    public function ageCalculation($birthday)
    {

        return($this->priceAward->ageCalculation($birthday));

    }


    // Fonction calcul du prix de la place du visiteur, en récupérant le service "calcul de prix"
    public function priceCalculation($age, $reduction){

        return($this->priceAward->priceCalculation($age, $reduction));

    }

}
