<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace macgyer\yii2materializecss;

/**
 * Description of Waves
 *
 * @author marco
 */
class Waves
{
    const INIT_WAVE = 'waves-effect';
    const WAVE_TEAL = 'waves-teal';
    const WAVE_LIGHT = 'waves-light';
    const WAVE_RED = 'waves-red';
    const WAVE_YELLOW = 'waves-yellow';
    const WAVE_ORANGE = 'waves-orange';
    const WAVE_PURPLE = 'waves-purple';
    const WAVE_GREEN = 'waves-green';
    const WAVE_CIRCLE = 'waves-circle';
    const WAVE_BLOCK = 'waves-block';
    const WAVE_FLOAT = 'waves-float';
    const WAVE_BUTTON = 'waves-button';
    public static function addWaveEffect(&$options, $color = self::WAVE_LIGHT, $form = '')
    {
        $class = self::INIT_WAVE . " $color $form";
        Html::addCssClass($options, $class);
    }
}