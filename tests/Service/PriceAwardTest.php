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



class PriceAwardTest extends TestCase
{
    public function testPriceCalculation()
    {
        $priceAward = new PriceAward();
        $result = $priceAward->priceCalculation("2001-01-01", false);

        $this->assertEquals(16, $result);
    }
};
