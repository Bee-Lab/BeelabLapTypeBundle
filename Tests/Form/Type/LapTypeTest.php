<?php

namespace Beelab\LapTypeBundle\Tests\Form\Type;

use Beelab\LapTypeBundle\Form\Type\LapType;
use PHPUnit\Framework\TestCase;

final class LapTypeTest extends TestCase
{
    public function testBuildView()
    {
        $form = $this->createMock('Symfony\Component\Form\FormInterface');
        $view = $this->getMockBuilder('Symfony\Component\Form\FormView')->disableOriginalConstructor()->getMock();
        $type = new LapType();
        $type->buildView($view, $form, ['with_hours' => true, 'with_milliseconds' => true]);
        $this->assertInstanceOf(LapType::class, $type);
    }

    public function testBuildForm()
    {
        $builder = $this->createMock('Symfony\Component\Form\FormBuilderInterface');
        $builder->expects($this->exactly(4))->method('add');
        $options = [
            'placeholders' => ['hour' => 'H', 'minute' => 'm', 'second' => 's', 'millisecond' => 'ms'],
            'hours' => \range(0, 23),
            'minutes' => \range(0, 59),
            'seconds' => \range(0, 59),
            'milliseconds' => \range(0, 99),
            'with_hours' => true,
            'with_milliseconds' => true,
            'required' => false,
        ];
        $type = new LapType();
        $type->buildForm($builder, $options);
    }

    public function testConfigureOptions()
    {
        $resolver = $this->createMock('Symfony\Component\OptionsResolver\OptionsResolver');
        $resolver->expects($this->once())->method('setDefaults');
        $resolver->expects($this->exactly(2))->method('setNormalizer');
        $type = new LapType();
        $type->configureOptions($resolver);
    }

    public function testGetBlockPrefix()
    {
        $type = new LapType();
        $this->assertEquals('beelab_lap', $type->getBlockPrefix());
    }
}
