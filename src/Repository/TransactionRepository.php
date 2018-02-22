<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function getNbVisitors($date)
    {
        $query = $this->createQueryBuilder('t')
            ->select('t.nbPersons')
            ->where('t.visitDate = :date')
            ->setParameter('date', $date)
            ->getQuery();
        $result=$query->getResult();

        $nbTotal=0;

        foreach ($result as $nb) {
            $nbTotal+=$nb['nbPersons'];
        }
        return ($nbTotal);
    }

    public function findTransactionById($id)
    {
        $query = $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getResult();
    }

}