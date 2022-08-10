<?php

namespace TheNightsWatch\Player\Controller;

use TheNightsWatch\Player\Model\User;
use yii\rest\Controller;

class ViewController extends Controller
{
    public function actionIndex($username)
    {
        /** @var User $user */
        $user = User::find()->where(['username' => $username])
            ->with('accolades')
            ->with('reprimands')
            ->with('honors')
            ->one();

        return [
            'id' => $user->id,
            'username' => $user->username,
            'rank' => $user->rank,
            'rankName' => User::getRankName($user->rank),
            'address' => $user->getTitleWithName(),
        ];
    }
}
