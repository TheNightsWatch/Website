<?php

namespace TheNightsWatch\Player\Model;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $minecraftId
 * @property string $password
 * @property int $rank
 * @property int $admin
 * @property string $joined
 * @property int $deniedJoin
 * @property int|null $order @deprecated
 * @property int $emailNotifications
 * @property string|null $title
 * @property int $banned
 * @property int $deserter
 * @property string|null $recruitmentDate
 * @property string|null $discordId
 * @property int $accordMember
 * @property int $lordCommanderClubMember
 * @property int $councilMember
 *
 * @property Accolade[] $accolades
 * @property Honor[] $honors
 * @property Ip[] $ips
 * @property Reprimand[] $reprimands
 */
class User extends ActiveRecord
{
    // Rank Constants, with space to grow.
    // The bigger the number, the higher the rank.
    public const RANK_ADMIN = 50000;
    public const RANK_COMMANDER = 10000;
    public const RANK_GENERAL = 5000;
    public const RANK_LIEUTENANT = 1000;
    public const RANK_CAPTAIN = 500;
    public const RANK_CORPORAL = 250;
    public const RANK_PRIVATE = 2;
    public const RANK_RECRUIT = 1;
    public const RANK_CIVILIAN = 0;

    // Order Constants
    public const ORDER_STEWARD = 0;
    public const ORDER_RANGER = 1;
    public const ORDER_BUILDER = 2;

    // Email Notification Constants, used as bitwise
    public const EMAIL_ANNOUNCEMENT = 0b1;
    public const EMAIL_ELECTION = 0b10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'minecraftId', 'password', 'rank', 'admin', 'joined', 'deniedJoin', 'emailNotifications', 'banned', 'deserter', 'accordMember', 'lordCommanderClubMember', 'councilMember'], 'required'],
            [['rank', 'order', 'emailNotifications',], 'integer'],
            [['admin', 'deniedJoin', 'banned', 'deserter', 'accordMember', 'lordCommanderClubMember', 'councilMember'], 'boolean'],
            [['joined', 'recruitmentDate'], 'safe'],
            [['username', 'email', 'minecraftId', 'password', 'title', 'discordId'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['minecraftId'], 'unique'],
            [['rank'], 'default', 'value' => static::RANK_CIVILIAN],
            [['admin', 'deniedJoin', 'banned', 'deserter', 'accordMember', 'lordCommanderClubMember', 'councilMember'], 'default', 'value' => false],
            [['joined', 'recruitmentDate', 'order', 'title', 'discordId'], 'default', 'value' => null],
            [['emailNotifications'], 'default', 'value' => static::EMAIL_ANNOUNCEMENT | static::EMAIL_ELECTION],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'minecraftId' => Yii::t('app', 'Minecraft ID'),
            'password' => Yii::t('app', 'Password'),
            'rank' => Yii::t('app', 'Rank'),
            'admin' => Yii::t('app', 'Admin'),
            'joined' => Yii::t('app', 'Joined'),
            'deniedJoin' => Yii::t('app', 'Denied Join'),
            'order' => Yii::t('app', 'Order'),
            'emailNotifications' => Yii::t('app', 'Email Notifications'),
            'title' => Yii::t('app', 'Title'),
            'banned' => Yii::t('app', 'Banned'),
            'deserter' => Yii::t('app', 'Deserter'),
            'recruitmentDate' => Yii::t('app', 'Recruitment Date'),
            'discordId' => Yii::t('app', 'Discord ID'),
            'accordMember' => Yii::t('app', 'Accord Member'),
        ];
    }

    public static function getRankNames(): array
    {
        return [
            static::RANK_ADMIN => 'Admin',
            static::RANK_COMMANDER => 'Lord Commander',
            static::RANK_CAPTAIN => 'Captain',
            static::RANK_PRIVATE => 'Ranger',
            static::RANK_RECRUIT => 'Recruit',
            static::RANK_CIVILIAN => 'Civilian',
        ];
    }

    public static function getRankName($rank): string
    {
        return static::getRankNames()[$rank];
    }

    public static function getOrderNames(): array
    {
        return [
            static::ORDER_STEWARD => 'Steward',
            static::ORDER_RANGER => 'Ranger',
            static::ORDER_BUILDER => 'Builder',
        ];
    }

    public static function getOrderName($order)
    {
        return static::getOrderNames()[$order];
    }

    public function getTitleOrRank()
    {
        if (!is_null($this->title)) {
            return sprintf($this->title, '', '');
        }
        if ($this->deserter) {
            return 'Deserter';
        }

        return static::getRankName($this->rank);
    }

    public function getTitleWithName(): string
    {
        if (!is_null($this->title)) {
            return sprintf($this->title, $this->username, '');
        }
        if ($this->deserter) {
            return $this->username . ', Deserter';
        }
        switch ($this->rank) {
            case static::RANK_RECRUIT:
                return $this->username . ', ' . static::getRankName($this->rank);
            case static::RANK_PRIVATE:
            case static::RANK_CORPORAL:
                return 'Ranger ' . $this->username;
            case static::RANK_CAPTAIN:
            case static::RANK_LIEUTENANT:
            case static::RANK_GENERAL:
                return 'Captain ' . $this->username;
            case static::RANK_COMMANDER:
                return 'Lord Commander ' . $this->username;
            default:
                return $this->username;
        }
    }

    /**
     * Gets query for [[Accolades0]].
     *
     * @return ActiveQuery
     */
    public function getAccolades()
    {
        return $this->hasMany(Accolade::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Honors]].
     *
     * @return ActiveQuery
     */
    public function getHonors()
    {
        return $this->hasMany(Honor::class, ['userId' => 'id']);
    }

    /**
     * Gets query for [[Ips]].
     *
     * @return ActiveQuery
     */
    public function getIps()
    {
        return $this->hasMany(Ip::class, ['userId' => 'id']);
    }

    /**
     * Gets query for [[Reprimands0]].
     *
     * @return ActiveQuery
     */
    public function getReprimands()
    {
        return $this->hasMany(Reprimand::class, ['user_id' => 'id']);
    }
}
