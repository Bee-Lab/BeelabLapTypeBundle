<?php

namespace Beelab\LapTypeBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms between a lap time (as integer, in milliseconds) and a lap array (hours, minutes, seconds, milliseconds).
 *
 * @author Massimiliano Arione <massimiliano.arione@bee-lab.net>
 */
final class LapToArrayTransformer implements DataTransformerInterface
{
    public function transform($lapInteger)
    {
        if (null === $lapInteger) {
            return;
        }
        if (!\is_int($lapInteger)) {
            throw new TransformationFailedException('Expected an integer.');
        }
        $millisecond = $lapInteger % 1000;
        $second = (($lapInteger - $millisecond) / 1000) % 60;
        $minute = (($lapInteger - $millisecond - $second * 1000) / 60000) % 60;
        $hour = ($lapInteger - $millisecond - $second * 1000 - $minute * 60 * 1000) / 3600000 % 24;

        return [
            'hour' => \str_pad($hour, 2, '0', STR_PAD_LEFT),
            'minute' => \str_pad($minute, 2, '0', STR_PAD_LEFT),
            'second' => \str_pad($second, 2, '0', STR_PAD_LEFT),
            'millisecond' => \str_pad($millisecond, 3, '0', STR_PAD_LEFT),
        ];
    }

    public function reverseTransform($lapArray)
    {
        if (null === $lapArray) {
            return;
        }
        if (!\is_array($lapArray)) {
            throw new TransformationFailedException('Expected an array.');
        }
        $millisecond = isset($lapArray['millisecond']) ? $lapArray['millisecond'] : 0;
        $second = $lapArray['second'];
        $minute = $lapArray['minute'];
        $hour = isset($lapArray['hour']) ? $lapArray['hour'] : 0;

        return ($hour * 3600000) + ($minute * 60000) + ($second * 1000) + $millisecond;
    }
}
