<?php

namespace TheNightsWatch\Election\Model;

use Yii;

/**
 * This is the model class for table "election".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $startDate
 * @property string $endDate
 * @property int $voteType
 *
 * @property ElectionOption[] $options
 */
class Election extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'election';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'startDate', 'endDate'], 'required'],
            [['description'], 'string'],
            [['startDate', 'endDate'], 'safe'],
            [['voteType'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'startDate' => Yii::t('app', 'Start Date'),
            'endDate' => Yii::t('app', 'End Date'),
            'voteType' => Yii::t('app', 'Vote Type'),
        ];
    }

    /**
     * Gets query for [[ElectionOptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(ElectionOption::class, ['election_id' => 'id']);
    }
}
