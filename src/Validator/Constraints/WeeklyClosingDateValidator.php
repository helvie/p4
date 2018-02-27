<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\Entity;
use DateInterval;
use DateTime;

class WeeklyClosingDateValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        $dayOfWeek = $value->format('N');

        if ($dayOfWeek == 2) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }

    }

}






