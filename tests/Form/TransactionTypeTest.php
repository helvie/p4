<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 13/03/2018
 * Time: 21:51
 */

namespace App\Tests\Form;


use App\Form\TransactionType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use App\Entity\Transaction;
use App\Entity\Person;
use DateTime;


class TransactionTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {




            $formData = array(


            'visitDate' => '2018-03-29',
            'nbPersons' => 2,
            'halfDay' => true,
            'email' => 'sylvie@gmail.com',
            'transactionCode' => "PERS18032800",
            //'persons[0][name]' => 'Helin',
/*            'persons[0][firstName]' => 'Sylvie',
            'persons[0][country]' => 'France',
            'persons[0][birth]' => '2001-01-01',
            'persons[0][reduction]' => false*/
            );


            $objectToCompare = new Transaction();
            $form = $this->factory->create(TransactionType::class, $objectToCompare);


//            $person = new Person();
//            $person->setName('Helin');
//            $person->setFirstName('Sylvie');
//            $person->setCountry('France');
//            $person->setBirth(new DateTime('2001-01-01'));
//            $person->setReduction(false);

            $model = new Transaction();
            $model->setVisitDate(new DateTime("2018-03-29"));
            $model->setNbPersons(2.00);
            $model->setHalfDay(true);
            $model->setEmail('sylvie@gmail.com');
            $model->setTransactionCode("PERS18032800");

//            $model->getPersons()->add($person);



        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($model, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);

    }
}}