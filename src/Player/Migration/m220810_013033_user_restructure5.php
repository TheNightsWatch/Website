<?php

namespace TheNightsWatch\Player\Migration;

use TheNightsWatch\Player\Model\User;
use yii\db\Migration;

/**
 * Class m220810_013033_user_restructure5
 */
class m220810_013033_user_restructure5 extends Migration
{
    public function up()
    {
        $this->addColumn(
            User::tableName(),
            'lordCommanderClubMember',
            $this->boolean()
                ->notNull()
                ->defaultValue(false)
        );
        $this->addColumn(
            User::tableName(),
            'councilMember',
            $this->boolean()
                ->notNull()
                ->defaultValue(false)
        );
    }

    public function down()
    {
        $this->dropColumn(User::tableName(), 'lordCommanderClubMember');
        $this->dropColumn(User::tableName(), 'councilMember');
    }
}
