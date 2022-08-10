<?php

namespace TheNightsWatch\Events\Model;

use Yii;
use TheNightsWatch\Player\Model\User;

/**
 * This is the model class for table "rsvp".
 *
 * @property int $event_id
 * @property int $user_id
 * @property int $attendance
 * @property bool $attended
 * @property string $timestamp
 * @property string|null $notes
 *
 * @property Event $event
 * @property User $user
 */
class Rsvp extends \yii\db\ActiveRecord
{
    public const RSVP_ABSENT = 0;
    public const RSVP_ATTENDING = 1;
    public const RSVP_MAYBE = 2;
    public const RSVP_NONE = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rsvp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'user_id', 'attendance', 'timestamp'], 'required'],
            [['event_id', 'user_id', 'attendance'], 'integer'],
            [['attended'], 'boolean'],
            [['timestamp'], 'safe'],
            [['notes'], 'string'],
            [['event_id', 'user_id'], 'unique', 'targetAttribute' => ['event_id', 'user_id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['attendance'], 'default', 'value' => static::RSVP_ABSENT],
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
            'attendance' => Yii::t('app', 'Attendance'),
            'attended' => Yii::t('app', 'Attended'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'notes' => Yii::t('app', 'Notes'),
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
