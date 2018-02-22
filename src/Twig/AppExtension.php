<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use DateTime;
use App\Service\PriceAward;

class AppExtension extends AbstractExtension {
    public function getFunctions(){
        return array(
        'price' => new \Twig_Function('priceCalculation', array($this, 'priceCalculation')),
    );
}

    public function priceCalculation($birthday, $reduction)

    {
        $dateJour = new DateTime();
        $age = $birthday->diff($dateJour)->format('%y');

        if($age < 4 )
        {$price = 0;}
        elseif($age < 12)
        {$price = 8;}
        elseif($reduction == true)
        {$price=10;}
        elseif($age > 12 && $age < 60)
        {$price=16;}
        else{$price = 12;}

        return($price);

    }

}