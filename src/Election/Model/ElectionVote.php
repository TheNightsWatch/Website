<?php

namespace TheNightsWatch\Election\Model;

use Yii;
use TheNightsWatch\Player\Model\User;

/**
 * This is the model class for table "election_vote".
 *
 * @property int $id
 * @property int $voter_id
 * @property int $option_id
 * @property int|null $rank
 *
 * @property ElectionOption $option
 * @property User $voter
 */
class ElectionVote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'election_vote';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['voter_id', 'option_id'], 'required'],
            [['voter_id', 'option_id', 'rank'], 'integer'],
            [['voter_id', 'option_id'], 'unique', 'targetAttribute' => ['voter_id', 'option_id']],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => ElectionOption::class, 'targetAttribute' => ['option_id' => 'id']],
            [['voter_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['voter_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'voter_id' => Yii::t('app', 'Voter ID'),
            'option_id' => Yii::t('app', 'Option ID'),
            'rank' => Yii::t('app', 'Rank'),
        ];
    }

    /**
     * Gets query for [[Option]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(ElectionOption::class, ['id' => 'option_id']);
    }

    /**
     * Gets query for [[Voter]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVoter()
    {
        return $this->hasOne(User::class, ['id' => 'voter_id']);
    }
}
