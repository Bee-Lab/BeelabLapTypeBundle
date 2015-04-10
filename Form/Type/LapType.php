<?php

namespace Beelab\LapTypeBundle\Form\Type;

use Beelab\LapTypeBundle\Form\DataTransformer\LapToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LapType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $parts = array('hour', 'minute', 'second', 'millisecond');

        $hourOptions = array(
            'error_bubbling' => true,
            'attr'           => array(
                'placeholder' => $options['placeholders']['hour'],
                'min'         => 0,
                'max'         => 23,
            ),
        );
        $minuteOptions = array(
            'error_bubbling' => true,
            'attr'           => array(
                'placeholder' => $options['placeholders']['minute'],
                'min'         => 0,
                'max'         => 59,
            ),
        );
        $secondOptions = array(
            'error_bubbling' => true,
            'attr' => array(
                'placeholder' => $options['placeholders']['second'],
                'min'         => 0,
                'max'         => 59,
            ),
        );
        $millisecondOptions = array(
            'error_bubbling' => true,
            'attr'           => array(
                'placeholder' => $options['placeholders']['millisecond'],
                'min'         => 0,
                'max'         => 999,
            ),
        );

        foreach ($options['hours'] as $hour) {
            $hours[$hour] = str_pad($hour, 2, '0', STR_PAD_LEFT);
        }
        foreach ($options['minutes'] as $minute) {
            $minutes[$minute] = str_pad($minute, 2, '0', STR_PAD_LEFT);
        }
        foreach ($options['seconds'] as $second) {
            $seconds[$second] = str_pad($second, 2, '0', STR_PAD_LEFT);
        }
        foreach ($options['milliseconds'] as $millisecond) {
            $milliseconds[$millisecond] = str_pad($millisecond, 3, '0', STR_PAD_LEFT);
        }

        if ($options['with_hours']) {
            $builder->add('hour', 'integer', $hourOptions);
        }
        $builder->add('minute', 'integer', $minuteOptions);
        $builder->add('second', 'integer', $secondOptions);
        if ($options['with_milliseconds']) {
            $builder->add('millisecond', 'integer', $millisecondOptions);
        }

        $builder->addModelTransformer(new LapToArrayTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'with_hours'        => $options['with_hours'],
            'with_milliseconds' => $options['with_milliseconds'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $compound = function (Options $options) {
            return true;
        };

        $emptyValue = $placeholderDefault = function (Options $options) {
            return $options['required'] ? null : '';
        };

        // for BC with the "empty_value" option
        $placeholder = function (Options $options) {
            return $options['empty_value'];
        };

        $placeholderNormalizer = function (Options $options, $placeholder) use ($placeholderDefault) {
            if (is_array($placeholder)) {
                $default = $placeholderDefault($options);

                return array_merge(
                    array('hour' => $default, 'minute' => $default, 'second' => $default, 'millisecond' => $default),
                    $placeholder
                );
            }

            return array(
                'hour'        => $placeholder,
                'minute'      => $placeholder,
                'second'      => $placeholder,
                'millisecond' => $placeholder,
            );
        };

        $resolver->setDefaults(array(
            'hours' => range(0, 23),
            'minutes' => range(0, 59),
            'seconds' => range(0, 59),
            'milliseconds' => range(0, 999),
            'with_hours' => true,
            'with_milliseconds' => true,
            'empty_value' => $emptyValue, // deprecated
            'placeholder' => $placeholder,
            'placeholders' => array('hour' => 'hh', 'minute' => 'mm', 'second' => 'ss', 'millisecond' => '000'),
            'error_bubbling' => false,
            'compound' => $compound,
        ));

        $resolver->setNormalizers(array(
            'empty_value' => $placeholderNormalizer,
            'placeholder' => $placeholderNormalizer,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'beelab_lap';
    }
}
