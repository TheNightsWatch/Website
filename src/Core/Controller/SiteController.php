<?php

namespace TheNightsWatch\Core\Controller;

use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return ['success' => true];
    }
}
