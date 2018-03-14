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


class TransactionTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'visitDate' => '2018-03-28',
            'nbPersons' => 2,
            'halfDay' => true,
            'email' => 'sylvie@gmail.com',
            'persons' => array(1,2,3,4),
            'transactionCode' => "PERS18032800",


        );

        $objectToCompare = new TestObject();
        // $objectToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(TransactionType::class, $objectToCompare);

        $object = new TestObject();
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($object, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}