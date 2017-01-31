<?php

namespace Beelab\LapTypeBundle\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * BeelabLapTypeTwigExtension.
 */
class BeelabLapTypeTwigExtension extends Twig_Extension
{
    /**
     * Converts a milliseconds lap in a lap made of hours:minutes:seconds.milliseconds.
     *
     * @param int  $lapInteger
     * @param bool $hours      Wether to use hours or not
     *
     * @return string
     */
    public function lap($lapInteger, $hours = true)
    {
        $return = '';
        $millisecond = $lapInteger % 1000;
        $second = (($lapInteger - $millisecond) / 1000) % 60;
        $minute = (($lapInteger - $millisecond - $second * 1000) / 60000) % 60;
        if ($hours) {
            $hour = ($lapInteger - $millisecond - $second * 1000 - $minute * 60 * 1000) / 3600000 % 24;
            $return = $hour.':';
        }
        $minute = str_pad($minute, 2, '0', STR_PAD_LEFT);
        $second = str_pad($second, 2, '0', STR_PAD_LEFT);
        $millisecond = str_pad($millisecond, 3, '0', STR_PAD_LEFT);

        return $return."$minute:$second.$millisecond";
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('lap', [$this, 'lap']),
        ];
    }
}
