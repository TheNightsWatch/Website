<?php

namespace TheNightsWatch\Events;

use Yii;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        Yii::configure($this, require(__DIR__ . '/etc/config.php'));
    }
}