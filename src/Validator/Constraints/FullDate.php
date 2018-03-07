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
 * Class FullDate
 * @package App\Validator\Constraints
 * @Annotation
 */
class FullDate extends Constraint
{
    public $message = "Il n'y a plus de place disponible à cette date !";

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}

