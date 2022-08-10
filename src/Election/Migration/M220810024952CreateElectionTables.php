<?php

namespace TheNightsWatch\Election\Migration;

use yii\db\Migration;

/**
 * Class M220810024952CreateElectionTables
 */
class M220810024952CreateElectionTables extends Migration
{
    public function up()
    {
        $this->createTable(
            'election',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string()->notNull(),
                'description' => $this->text()->null(),
                'startDate' => $this->dateTime()->notNull(),
                'endDate' => $this->dateTime()->notNull(),
                'voteType' => $this->integer()->notNull()->defaultValue(0),
            ]
        );
        $this->createTable(
            'election_option',
            [
                'id' => $this->primaryKey()->unsigned(),
                'election_id' => $this->integer()->unsigned()->notNull(),
                'title' => $this->string()->null(),
                'description' => $this->text()->null(),
                'user_id' => $this->integer()->null(),
            ]
        );
        $this->createIndex('idx-election_option-election_id', 'election_option', 'election_id');
        $this->addForeignKey(
            'fk-election_option-election_id',
            'election_option',
            'election_id',
            'election',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->createIndex('idx-election_option-user_id', 'election_option', 'user_id');
        $this->addForeignKey(
            'fk-election_option-user_id',
            'election_option',
            'user_id',
            'user',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->createTable(
            'election_vote',
            [
                'id' => $this->primaryKey()->unsigned(),
                'voter_id' => $this->integer()->notNull(),
                'option_id' => $this->integer()->unsigned()->notNull(),
                'rank' => $this->integer()->unsigned()->null(),
            ]
        );
        $this->createIndex('idx-election_vote-voter_id', 'election_vote', 'voter_id');
        $this->addForeignKey(
            'fk-election_vote-voter_id',
            'election_vote',
            'voter_id',
            'user',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->createIndex('idx-election_vote-option_id', 'election_vote', 'option_id');
        $this->addForeignKey(
            'fk-election_vote-option_id',
            'election_vote',
            'option_id',
            'election_option',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex(
            'idx-election_vote-unique-voter_id-option_id',
            'election_vote',
            ['voter_id', 'option_id'],
            true
        );
    }

    public function down()
    {
        $this->dropTable('election_vote');
        $this->dropTable('election_option');
        $this->dropTable('election');
    }
}
