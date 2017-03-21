<?php

namespace TheNightsWatch\Events\Controller;

use yii\rest\Controller;

class ViewController extends Controller
{
    public function actionIndex($id)
    {
        return [
            'id' => $id,
        ];
    }
}