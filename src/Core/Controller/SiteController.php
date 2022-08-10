<?php

namespace TheNightsWatch\Core\Controller;

use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
