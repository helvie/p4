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
 * Class WithoutReservationDate
 * @package App\Validator\Constraints
 * @Annotation
 */
class TodayEvening extends Constraint
{
    public $message = "Il n'est plus possible de réserver ce jour";

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}
