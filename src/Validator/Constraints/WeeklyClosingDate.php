<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Validation;

use App\Repository\TransactionRepository;
use App\Entity\Transaction;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Entity;

/**
 * Class WeeklyClosingDate
 * @package App\Validator\Constraints
 * @Annotation
 */
class WeeklyClosingDate extends Constraint
{
    public $message = "C'est un jour de fermeture hebdomadaire !";

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}
