<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use DateTime;
//use Doctrine\ORM\Entity;



class TodayEveningValidator extends ConstraintValidator
{

    // Vérification s'il s'agit d'une commande le jour même, qu'il ne soit pas plus de 14h, afin de ne pas vendre de billet à la journée
    public function validate($value, Constraint $constraint)
    {
        $today = new DateTime();
        if ($today->format("yy/mm/dd") == $value->format("yy/mm/dd"))
        {
            if (($today->format('H'))>=17) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }

    }

}






