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
     * @Assert\Length(min=2,max=30,minMessage="Veuillez saisir 2 caractères minimum ", maxMessage="Veuillez saisir un maximum de 30 caractères")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le nom ne doit pas contenir de chiffre"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(min=2,max=30,minMessage="Veuillez saisir 2 caractères minimum ", maxMessage="Veuillez saisir un maximum de 30 caractères")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le prénom ne doit pas contenir de chiffre"
     * )
     *
     */
    private $firstName;


    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(min=2,max=30,minMessage="Veuillez saisir 2 caractères minimum ", maxMessage="Veuillez saisir un maximum de 30 caractères")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="La ville ne doit pas contenir de chiffre"
     * )
     *
     */
    private $country;


    /**
     * @ORM\Column(type="date")
     * @Assert\LessThan(value = "today", message = "La date de naissance est invalide")
     * @Assert\GreaterThan(value = "-120 years", message = "La date de naissance est invalide")
     *
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