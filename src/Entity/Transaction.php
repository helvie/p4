<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 10/01/2018
 * Time: 21:58
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use App\Validator\Constraints as AcmeAssert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual("today")
     * @AcmeAssert\WeeklyClosingDate
     * @AcmeAssert\WithoutReservationDate
     * @AcmeAssert\HolidayDate
     * @AcmeAssert\FullDate
     */
    private $visitDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $halfDay;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPersons;

    /**
     * @ORM\Column(type="string")
     */
    private $email;


    /**
    * @ORM\OneToMany(targetEntity="Person", mappedBy="transaction", cascade="all", orphanRemoval=true)
    */
    protected $persons;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }

    /**
     * @param mixed $visitDate
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;
    }


    /**
     * @return mixed
     */
    public function getHalfDay()
    {
        return $this->halfDay;
    }

    /**
     * @param mixed $halfDay
     */
    public function setHalfDay($halfDay)
    {
        $this->halfDay = $halfDay;
    }


    /**
     * @return mixed
     */
    public function getNbPersons()
    {
        return $this->nbPersons;
    }

    /**
     * @param mixed $nbPersons
     */
    public function setNbPersons($nbPersons)
    {
        $this->nbPersons = $nbPersons;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }



    public function __construct()
    {
        $this->persons = new ArrayCollection();
    }

    public function getPersons()
    {
        return $this->persons;
    }






}
