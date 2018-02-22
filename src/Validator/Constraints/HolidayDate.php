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
 * Class HolidayDate
 * @package App\Validator\Constraints
 * @Annotation
 */


class HolidayDate extends Constraint
{
    public $message = "C'est férié !";

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}