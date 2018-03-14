<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 13/03/2018
 * Time: 23:03
 */


namespace App\Tests\Repository;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\RegistryInterface;


class TransactionRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();


        $this->entityManager = $kernel
            ->getContainer()
            ->get("doctrine")
            ->getManager();
    }



    public function testGetNbVisitors()
    {
        $transactions = $this->entityManager
            ->getRepository(Transaction::class)
            ->getNbVisitors(new DateTime('2018-03-31'))
        ;

        $this->assertGreaterThan(1000 , $transactions);
    }


}