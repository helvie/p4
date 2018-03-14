<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 13/03/2018
 * Time: 21:51
 */

namespace App\Tests\Form;


use App\Form\PersonType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use App\Entity\Transaction;
use App\Entity\Person;
use DateTime;


class PersonTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
            $formData = array(

                'name' => 'Helin',
                'firstName' => "Sylvie",
                'country' => 'France',
                'birth' => '2001-01-01',
                'reduction' => false,

            );


            $objectToCompare = new Person();
            $form = $this->factory->create(PersonType::class, $objectToCompare);

            $person = new Person();
            $person->setName('Helin');
            $person->setFirstName('Sylvie');
            $person->setCountry('France');
            $person->setBirth(new DateTime('2001-01-01'));
            $person->setReduction(false);


        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($person, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);

    }
}}