<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 10/01/2018
 * Time: 22:39
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AcmeAssert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */

class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstName;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $country;


    /**
     * @ORM\Column(type="date")
     */
    private $birth;


    /**
     * @ORM\Column(type="boolean")
     */
    private $reduction;




    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Transaction" , inversedBy="persons")
     * @ORM\JoinColumn(nullable=true)
     */
    private $transaction;




    public function getAge()
    {
        $dateInterval = $this->birth->diff(new \DateTime());

        return $dateInterval->y;
    }


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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * @param mixed $birth
     */
    public function setBirth($birth)
    {
        $this->birth = $birth;
    }

    /**
     * @return mixed
     */
    public function getReduction()
    {
        return $this->reduction;
    }

    /**
     * @param mixed $reduction
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;
    }


    /**
     * @return mixed
     */

    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param mixed $transaction
     */

    public function setTransaction(Transaction $id)
    {
        $this->transaction = $id;
    }
}