<?php

namespace TheNightsWatch\Player\Controller;

use yii\rest\Controller;

class ViewController extends Controller
{
    public function actionIndex($name)
    {
        return [
            'name' => $name,
        ];
    }
}