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
    public function testPriceCalculation()
    {
        $priceAward = new PriceAward();
        $birthday = new DateTime("2001-01-01");
        $result = $priceAward->priceCalculation($birthday, false);

        $this->assertEquals(16, $result);
    }
};
