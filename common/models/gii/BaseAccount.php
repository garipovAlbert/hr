<?php

namespace common\models\gii;

use common\models\Cinema;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%account}}".
 *
 * @property integer $id
 * @property string $role
 * @property string $status
 * @property string $authKey
 * @property string $email
 * @property string $passwordHash
 * @property string $publicPassword
 * @property string $username
 * @property string $position
 * @property integer $createdBy
 * @property integer $updatedBy
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property AccountCinemaLink[] $accountCinemaLinks
 * @property Cinema[] $cinemas
 */
class BaseAccount extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role', 'authKey', 'email', 'username', 'createdAt', 'updatedAt'], 'required'],
            [['status'], 'string'],
            [['createdBy', 'updatedBy', 'createdAt', 'updatedAt'], 'integer'],
            [['role'], 'string', 'max' => 31],
            [['authKey'], 'string', 'max' => 32],
            [['email', 'passwordHash', 'publicPassword', 'username', 'position'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Status'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'email' => Yii::t('app', 'Email'),
            'passwordHash' => Yii::t('app', 'Password Hash'),
            'publicPassword' => Yii::t('app', 'Public Password'),
            'username' => Yii::t('app', 'Username'),
            'position' => Yii::t('app', 'Position'),
            'createdBy' => Yii::t('app', 'Created By'),
            'updatedBy' => Yii::t('app', 'Updated By'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAccountCinemaLinks()
    {
        return $this->hasMany(AccountCinemaLink::className(), ['accountId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCinemas()
    {
        return $this->hasMany(Cinema::className(), ['id' => 'cinemaId'])->viaTable('{{%account_cinema_link}}', ['accountId' => 'id']);
    }

}