<?php

namespace common\models\gii;

use common\models\Cinema;
use common\models\queries\AccountQuery;
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
 * @property string $login
 * @property string $passwordHash
 * @property string $email
 * @property string $firstName
 * @property string $lastName
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
            [['role', 'authKey', 'login', 'passwordHash', 'firstName', 'lastName', 'createdAt', 'updatedAt'], 'required'],
            [['status'], 'string'],
            [['createdBy', 'updatedBy', 'createdAt', 'updatedAt'], 'integer'],
            [['role'], 'string', 'max' => 31],
            [['authKey', 'firstName', 'lastName'], 'string', 'max' => 32],
            [['login', 'passwordHash', 'email', 'position'], 'string', 'max' => 255],
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
            'login' => Yii::t('app', 'Login'),
            'passwordHash' => Yii::t('app', 'Password Hash'),
            'email' => Yii::t('app', 'Email'),
            'firstName' => Yii::t('app', 'First Name'),
            'lastName' => Yii::t('app', 'Last Name'),
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

    /**
     * @inheritdoc
     * @return AccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccountQuery(get_called_class());
    }

}