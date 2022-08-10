<?php

namespace TheNightsWatch\Election\Model;

use Yii;
use TheNightsWatch\Player\Model\User;

/**
 * This is the model class for table "election_option".
 *
 * @property int $id
 * @property int $election_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $user_id
 *
 * @property Election $election
 * @property ElectionVote[] $votes
 * @property User $user
 * @property User[] $voters
 */
class ElectionOption extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'election_option';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['election_id'], 'required'],
            [['election_id', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['election_id'], 'exist', 'skipOnError' => true, 'targetClass' => Election::class, 'targetAttribute' => ['election_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'election_id' => Yii::t('app', 'Election ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * Gets query for [[Election]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getElection()
    {
        return $this->hasOne(Election::class, ['id' => 'election_id']);
    }

    /**
     * Gets query for [[ElectionVotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasMany(ElectionVote::class, ['option_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Voters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVoters()
    {
        return $this->hasMany(User::class, ['id' => 'voter_id'])->viaTable('election_vote', ['option_id' => 'id']);
    }
}
