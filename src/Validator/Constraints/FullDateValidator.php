<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use App\Repository\TransactionRepository;
use App\Entity\Transaction;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Entity;


use Doctrine\Bundle\DoctrineBundle\Repository;
use App\Form\TransactionType;
use App\Controller\TicketPurchaseController;
use Doctrine\ORM\EntityManager;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use App\Validator\Constraints\FullDate;


class FullDateValidator extends ConstraintValidator
{

    protected $em;

    public function __construct(Doctrine $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    public function validate($value, Constraint $constraint)
    {
        $repository=$this->em
            ->getRepository(Transaction::Class);

        $dayFilter = $repository->getNbVisitors($value);

        if ($dayFilter > 1000) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }

    }
}




