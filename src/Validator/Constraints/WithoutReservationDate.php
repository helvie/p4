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
class WithoutReservationDate extends Constraint
{
    public $message = "Il n'y a pas de réservation possible le dimanche";

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}
