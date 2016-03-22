<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace macgyer\yii2materializecss;

class BasicCard extends Card
{
    public function init()
    {
        parent::init();
        echo $this->beginContent();
        echo $this->renderTitle();
    }
    
    public function run()
    {
        echo $this->endContent();
        parent::run();
    }
}