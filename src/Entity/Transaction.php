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
use App\Validator\Constraints as AcmeAssert;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @Assert\GreaterThanOrEqual(value = "today", message = "La date choisie est passée")
     * @Assert\LessThanOrEqual(value = "+5 years", message = "Veuillez choisir une date antérieure (5 années maximum)")
     * @AcmeAssert\WeeklyClosingDate
     * @AcmeAssert\WithoutReservationDate
     * @AcmeAssert\HolidayDate
     * @AcmeAssert\FullDate
     * @AcmeAssert\TodayEvening
     */
    private $visitDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $halfDay;

    /**
     * @Assert\LessThanOrEqual(value = "30", message = "Pour les groupes supérieurs à 30 personnes, merci de nous contacter")
     * @Assert\GreaterThan(value = "0", message = "Vous devez entrer un nombre valide")
     * @ORM\Column(type="integer")
     */
    private $nbPersons;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $transactionCode;


    /**
    * @ORM\OneToMany(targetEntity="Person", mappedBy="transaction", cascade="all", orphanRemoval=true)
     *  @Assert\Valid
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

    /**
     * @return mixed
     */
    public function getTransactionCode()
    {
        return $this->transactionCode;
    }

    /**
     * @param mixed $transactionCode
     */
    public function setTransactionCode($transactionCode)
    {
        $this->transactionCode = $transactionCode;
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
