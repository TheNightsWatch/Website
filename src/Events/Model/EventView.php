<?php

namespace TheNightsWatch\Events\Model;

use Yii;
use TheNightsWatch\Player\Model\User;

/**
 * This is the model class for table "event_view".
 *
 * @property int $event_id
 * @property int $user_id
 * @property string $firstViewed
 * @property string $lastViewed
 *
 * @property Event $event
 * @property User $user
 */
class EventView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'user_id', 'firstViewed', 'lastViewed'], 'required'],
            [['event_id', 'user_id'], 'integer'],
            [['firstViewed', 'lastViewed'], 'safe'],
            [['event_id', 'user_id'], 'unique', 'targetAttribute' => ['event_id', 'user_id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => Yii::t('app', 'Event ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'firstViewed' => Yii::t('app', 'First Viewed'),
            'lastViewed' => Yii::t('app', 'Last Viewed'),
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
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
