<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\Entity;
use DateInterval;
use DateTime;

class TodayEveningValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        $today = new DateTime();
        if ($today->format("Y/M/D") == $value->format("Y/M/D"))
        {
            if (($today->format('H'))>17) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }

    }

}






