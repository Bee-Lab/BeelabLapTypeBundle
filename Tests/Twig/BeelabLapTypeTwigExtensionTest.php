<?php

namespace Beelab\LapTypeBundle\Tests\Twig;

use Beelab\LapTypeBundle\Twig\BeelabLapTypeTwigExtension;
use PHPUnit_Framework_TestCase as TestCase;

class BeelabLapTypeTwigExtensionTest extends TestCase
{
    public function testLap()
    {
        $ext = new BeelabLapTypeTwigExtension();
        $lap = $ext->lap(120000);
        $this->assertEquals('0:02:00.000', $lap);
        $lap = $ext->lap(120000, false);
        $this->assertEquals('02:00.000', $lap);
    }

    public function testGetFilters()
    {
        $ext = new BeelabLapTypeTwigExtension();
        $filters = $ext->getFilters();
        $this->assertCount(1, $filters);
    }
}
