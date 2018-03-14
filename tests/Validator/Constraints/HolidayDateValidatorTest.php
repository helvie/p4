<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 13/03/2018
 * Time: 22:37
 */

namespace Tests\Validator\Constraints;

use App\Validator\Constraints\HolidayDate;
use App\Validator\Constraints\HolidayDateValidator;
use PHPUnit\Framework\TestCase;
use DateTime;



class HolidayDateValidatorTest extends TestCase
{
    /**
     * Configure a SomeConstraintValidator.
     *
     * @param string $expectedMessage The expected message on a validation violation, if any.
     *
     * @return App\Validator\Constraints\HolidayDateValidator;
     */
    public function configureValidator($expectedMessage = null)
    {
        // mock the violation builder
        $builder = $this->getMockBuilder('Symfony\Component\Validator\Violation\ConstraintViolationBuilder')
            ->disableOriginalConstructor()
            ->setMethods(array('addViolation'))
            ->getMock()
        ;

        // mock the validator context
        $context = $this->getMockBuilder('Symfony\Component\Validator\Context\ExecutionContext')
            ->disableOriginalConstructor()
            ->setMethods(array('buildViolation'))
            ->getMock()
        ;

        if ($expectedMessage) {
            $builder->expects($this->once())
                ->method('addViolation')
            ;

            $context->expects($this->once())
                ->method('buildViolation')
                ->with($this->equalTo($expectedMessage))
                ->will($this->returnValue($builder))
            ;
        }
        else {
            $context->expects($this->never())
                ->method('buildViolation')
            ;
        }

        // initialize the validator with the mocked context
        $validator = new HolidayDateValidator();
        $validator->initialize($context);

        // return the SomeConstraintValidator
        return $validator;
    }

    /**
     * Verify a constraint message is triggered when value is invalid.
     */
    public function testValidateOnInvalid()
    {
        $constraint = new HolidayDate();
        $validator = $this->configureValidator($constraint->message);

        $validator->validate(new DateTime('2018-12-25'), $constraint);
    }

    /**
     * Verify no constraint message is triggered when value is valid.
     */
    public function testValidateOnValid()
    {
        $constraint = new HolidayDate();
        $validator = $this->configureValidator();

        $validator->validate(new DateTime('2018-03-31'), $constraint);
    }
}