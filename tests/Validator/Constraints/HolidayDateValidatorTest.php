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
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;


class HolidayDateValidatorTest extends TestCase
{
    private $constraint;
    private $context;

    public function setUp()
    {
        $this->constraint = new HolidayDate();
        $this->context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')
            ->disableOriginalConstructor()->getMock();
    }

    public function testValidate()
    {
        /*ConstraintValidator*/
        $validator = new HolidayDateValidator();
        $validator->initialize($this->context);

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with($this->constraint->message, array());
        $validator->validate(\Datetime::createFromFormat("d/m/Y", "10/10/2000"), $this->constraint);
    }

    public function tearDown()
    {
        $this->constraint = null;
    }
}

//
//
//namespace App\Validator\Constraints;
//
//use Symfony\Component\Validator\Constraint;
//use Symfony\Component\Validator\ConstraintValidator;
//use DateInterval;
//use DateTime;
////use Doctrine\ORM\Entity;
//
//
//class HolidayDateValidator extends ConstraintValidator
//{
//
//    public function validate($value, Constraint $constraint)
//    {
//        $year = $value->format('Y');
//        $base = new DateTime("$year-03-21");
//        $days = easter_days($year);
//
//        $easter = $base->add(new DateInterval("P{$days}D"));
//        $easterM = date("Y-m-d", strtotime($easter->format("Y-m-d") . " +1 days"));
//        $ascent = date("Y-m-d", strtotime($easter->format("Y-m-d") . " +39 days"));
//        $pentecost = date("Y-m-d", strtotime($easter->format("Y-m-d") . " +50 days"));
//
//        $holidayArray = array($easterM, $ascent, $pentecost, "$year-01-01", "$year-05-01", "$year-05-08",
//            "$year-07-14", "$year-08-15", "$year-11-01", "$year-11-11", "$year-12-25");
//
//        global $holiday;
//        $holiday = false;
//
//        for ($i = 0; $i < count($holidayArray); $i++) {
//            if ($value->format("Y-m-d") == $holidayArray[$i]) {
//                $holiday = true;
//                break;
//            }
//        }
//        if ($holiday == true) {
//            $this->context->buildViolation($constraint->message)
//                ->addViolation();
//        }
//
//    }
//
//}
//
//class HolidayDate extends Constraint
//{
//    public $message = "Veuillez choisir un jour non férié";
//
//    public function validatedBy()
//    {
//        return get_class($this) . 'Validator';
//    }
//}