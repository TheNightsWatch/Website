<?php

namespace TheNightsWatch\Events\Model;

use Yii;
use TheNightsWatch\Player\Model\User;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $description
 * @property string $start
 * @property int $lowestViewableRank
 * @property int $region
 * @property int|null $leader_id
 * @property int $type
 * @property string|null $report
 * @property int $accord
 *
 * @property EventView[] $eventViews
 * @property User $leader
 * @property Rsvp[] $rsvps
 * @property User $creator
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'lowestViewableRank', 'region', 'leader_id', 'type', 'accord'], 'integer'],
            [['name', 'description', 'start', 'lowestViewableRank', 'region', 'type', 'accord'], 'required'],
            [['description', 'report'], 'string'],
            [['start'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['leader_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['leader_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'start' => Yii::t('app', 'Start'),
            'lowestViewableRank' => Yii::t('app', 'Lowest Viewable Rank'),
            'region' => Yii::t('app', 'Region'),
            'leader_id' => Yii::t('app', 'Leader ID'),
            'type' => Yii::t('app', 'Type'),
            'report' => Yii::t('app', 'Report'),
            'accord' => Yii::t('app', 'Accord'),
        ];
    }

    /**
     * Gets query for [[Leader]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeader()
    {
        if ($this->leader_id) {
            return $this->hasOne(User::class, ['id' => 'leader_id']);
        } else {
            return $this->getCreator();
        }
    }

    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Rsvps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRsvps()
    {
        return $this->hasMany(Rsvp::class, ['event_id' => 'id']);
    }
}
