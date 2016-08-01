<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Dollar;

class DollarTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider serializationProvider
     *
     * @param int    $amount
     * @param string $expected
     */
    public function serialization(int $amount, string $expected)
    {
        $dollar = new Dollar($amount);

        $this->assertSame((string)$dollar, $expected);
    }

    public function serializationProvider()
    {
        return [
            'penniless' =>      [0,         '$0.00'],
            'one cent' =>       [1,         '$0.01'],
            'thirteen cents' => [13,        '$0.13'],
            'one dollar' =>     [100,       '$1.00'],
            'some 2k' =>        [189327,    '$1,893.27'],
            'million + cent' => [100000001, '$1,000,000.01']
        ];
    }

    /**
     * @test
     */
    public function debitsAreNotModelled()
    {
        $this->expectException(\DomainException::class);

        new Dollar(-1);
    }
}
