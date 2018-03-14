<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 13/03/2018
 * Time: 20:49
 */


namespace tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/'),
            array('/transaction'),
            array('/cardNumber'),
            //array('/validPayment'),
        );
    }
}