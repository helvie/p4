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
    public function ageCalculation($birthday)
    {
        $dateToday = new DateTime();
        $age1 = $birthday->diff($dateToday);
        $age = $age1->format('%y');

        return($age);

    }

    public function priceCalculation($age, $reduction){

        if ($age < 4) {
            $price = 0;
        } elseif ($age < 13) {
            $price = 8;
        } elseif ($reduction == true) {
            $price = 10;
        } elseif ($age > 12 && $age < 60) {
            $price = 16;
        } else {
            $price = 12;
        }

        return ($price);

    }

}

