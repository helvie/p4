<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 06/03/2018
 * Time: 17:58
 */

namespace tests\Service;

use App\Service\PriceAward;
use PHPUnit\Framework\TestCase;
use DateTime;



class PriceAwardTest extends TestCase
{
    public function testAgeCalculation(){
        $priceAward = new priceAward();
        $birthday = new DateTime('2006-03-01');
        $result = $priceAward ->ageCalculation($birthday);

        $this->assertEquals(12, $result);

    }

    public function testPriceCalculation()
    {
        $priceAward = new PriceAward();
        $age = 12;
        $result = $priceAward->priceCalculation($age, false);

        $this->assertEquals(8, $result);
    }
};
