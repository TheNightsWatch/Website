<?php

namespace TheNightsWatch\Player\Migration;

use TheNightsWatch\Player\Model\User;
use yii\db\Migration;

/**
 * Class m220810_013711_update_ranks_restructure5
 */
class m220810_013711_update_ranks_restructure5 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update(
            User::tableName(),
            ['rank' => User::RANK_CAPTAIN],
            ['between', 'rank', User::RANK_CAPTAIN + 1, User::RANK_COMMANDER - 1]
        );
        $this->update(
            User::tableName(),
            ['rank' => User::RANK_PRIVATE],
            ['between', 'rank', User::RANK_PRIVATE + 1, User::RANK_CAPTAIN - 1]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220810_013711_update_ranks_restructure5 cannot be reverted.\n";

        return false;
    }
}
