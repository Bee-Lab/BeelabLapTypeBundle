<?php

namespace Beelab\LapTypeBundle\Tests\DependencyInjection;

use Beelab\LapTypeBundle\DependencyInjection\Configuration;
use PHPUnit_Framework_TestCase as TestCase;

class ConfigurationTest extends TestCase
{
    public function testThatCanGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $this->assertInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder', $configuration->getConfigTreeBuilder());
    }
}
