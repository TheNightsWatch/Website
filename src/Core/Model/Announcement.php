<?php

namespace TheNightsWatch\Core\Model;

use Yii;
use TheNightsWatch\Player\Model\User;

/**
 * This is the model class for table "announcement".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property int $lowestReadableRank
 * @property string $timestamp
 *
 * @property User $user
 */
class Announcement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announcement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'lowestReadableRank'], 'integer'],
            [['title', 'content', 'lowestReadableRank', 'timestamp', 'user_id'], 'required'],
            [['content'], 'string'],
            [['timestamp'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'lowestReadableRank' => Yii::t('app', 'Lowest Readable Rank'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
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
}
