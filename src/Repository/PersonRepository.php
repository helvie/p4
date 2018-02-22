<?php

namespace App\Repository;


use App\Entity\Person;
use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class PersonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Person::class);
    }


    public function getPersonByTransactionId($transactionId)
    {
        $query = $this->createQueryBuilder('p')
            ->leftJoin('p.transaction', "t")
            ->addSelect('t')
            ->where('p.transaction = :transactionId')
            ->setParameter('transactionId', $transactionId)
            ->getQuery();

        return $query->getResult();
    }


    public function getPersonById($id)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getResult();
    }
}