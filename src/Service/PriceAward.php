<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 10/01/2018
 * Time: 23:01
 */

namespace App\Service;


use Doctrine\ORM\Entity;

use DateTime;



class PriceAward
{
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




