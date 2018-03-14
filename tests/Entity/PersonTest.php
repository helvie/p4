<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 14/03/2018
 * Time: 22:21
 */

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Person;

class PersonTest extends TestCase
{


    public function testName()
    {
        $person = $this->getMockForAbstractClass('App\Entity\Person');
        $person->setName('Helin');
        $this->assertNotNull($person->getName());
        $this->assertEquals('Helin', $person->getName());
    }

    public function testFirstName()
    {
        $person = $this->getMockForAbstractClass('App\Entity\Person');
        $person->setFirstName('Sylvie');
        $this->assertNotNull($person->getFirstName());
        $this->assertEquals('Sylvie', $person->getFirstName());
    }

    public function testCountry()
    {
        $person = $this->getMockForAbstractClass('App\Entity\Person');
        $person->setCountry('France');
        $this->assertNotNull($person->getCountry());
        $this->assertEquals('France', $person->getCountry());
    }

    public function testBirth()
    {
        $person = $this->getMockForAbstractClass('App\Entity\Person');
        $person->setBirth('2001-01-01');
        $this->assertNotNull($person->getBirth());
        $this->assertEquals('2001-01-01', $person->getBirth());
    }

    public function testReduction()
    {
        $person = $this->getMockForAbstractClass('App\Entity\Person');
        $person->setReduction(false);
        $this->assertNotNull($person->getReduction());
        $this->assertEquals(false, $person->getReduction());
    }

}
