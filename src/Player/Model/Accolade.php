<?php

namespace TheNightsWatch\Player\Model;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "accolade".
 *
 * @property int $id
 * @property int $user_id
 * @property int $giver_id
 * @property string $timestamp
 * @property string $reason
 * @property string $report
 * @property string $additionalInformation
 * @property string|null $voidedOn
 *
 * @property User $giver
 * @property User $user
 */
class Accolade extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accolade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'giver_id', 'timestamp', 'reason', 'report', 'additionalInformation'], 'required'],
            [['user_id', 'giver_id'], 'integer'],
            [['timestamp', 'voidedOn'], 'safe'],
            [['reason', 'report', 'additionalInformation'], 'string'],
            [['giver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['giver_id' => 'id']],
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
            'giver_id' => Yii::t('app', 'Giver ID'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'reason' => Yii::t('app', 'Reason'),
            'report' => Yii::t('app', 'Report'),
            'additionalInformation' => Yii::t('app', 'Additional Information'),
            'voidedOn' => Yii::t('app', 'Voided On'),
        ];
    }

    /**
     * Gets query for [[Giver]].
     *
     * @return ActiveQuery
     */
    public function getGiver()
    {
        return $this->hasOne(User::class, ['id' => 'giver_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
