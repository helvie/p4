<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\Entity;
use DateInterval;
use DateTime;

class HolidayDateValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        $year = $value->format('Y');
        $base = new DateTime("$year-03-21");
        $days = easter_days($year);

        $easter = $base->add(new DateInterval("P{$days}D"));
        $easterM = date("Y-m-d", strtotime($easter->format("Y-m-d") . " +1 days"));
        $ascent = date("Y-m-d", strtotime($easter->format("Y-m-d") . " +39 days"));
        $pentecost = date("Y-m-d", strtotime($easter->format("Y-m-d") . " +50 days"));

        $holidayArray = array($easterM, $ascent, $pentecost, "$year-01-01", "$year-05-01", "$year-05-08",
            "$year-07-14", "$year-08-15", "$year-11-01", "$year-11-11");

        global $holiday;
        $holiday = false;

        for ($i = 0; $i < count($holidayArray); $i++) {
            if ($value->format("Y-m-d") == $holidayArray[$i]) {
                $holiday = true;
                break;
            }
        }
        if ($holiday == true) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }

    }

}






