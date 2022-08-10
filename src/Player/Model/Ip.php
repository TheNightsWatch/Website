<?php

namespace TheNightsWatch\Player\Model;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ip".
 *
 * @property int $id
 * @property string $ip
 * @property string $firstSeen
 * @property string $lastSeen
 * @property int|null $userId
 *
 * @property User $user
 */
class Ip extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip', 'firstSeen', 'lastSeen'], 'required'],
            [['firstSeen', 'lastSeen'], 'safe'],
            [['userId'], 'integer'],
            [['ip'], 'ip'],
            [['userId', 'ip'], 'unique', 'targetAttribute' => ['userId', 'ip']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip' => Yii::t('app', 'Ip'),
            'firstSeen' => Yii::t('app', 'First Seen'),
            'lastSeen' => Yii::t('app', 'Last Seen'),
            'userId' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'userId']);
    }
}
