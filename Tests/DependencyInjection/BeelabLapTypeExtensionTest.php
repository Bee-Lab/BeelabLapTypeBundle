<?php

namespace Beelab\LapTypeBundle\Tests\DependencyInjection;

use Beelab\LapTypeBundle\DependencyInjection\BeelabLapTypeExtension;
use PHPUnit\Framework\TestCase;

final class BeelabLapTypeExtensionTest extends TestCase
{
    public function testLoadFailure()
    {
        $container = $this
            ->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $extension = $this->createMock('Beelab\\LapTypeBundle\\DependencyInjection\\BeelabLapTypeExtension');

        $extension->load([[]], $container);

        $this->assertTrue(true);
    }

    public function testLoadSetParameters()
    {
        $container = $this
            ->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $parameterBag = $this
            ->getMockBuilder('Symfony\Component\DependencyInjection\ParameterBag\\ParameterBag')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $parameterBag->expects($this->any())->method('add');
        $container->expects($this->any())->method('getParameterBag')->will($this->returnValue($parameterBag));

        $extension = new BeelabLapTypeExtension();
        $configs = [
            ['lap_form_type' => 'RandomType'],
        ];
        $extension->load($configs, $container);

        $this->assertTrue(true);
    }
}
