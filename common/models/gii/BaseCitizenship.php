<?php

namespace common\models\gii;

use common\models\Applicant;
use common\models\queries\CitizenshipQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%citizenship}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $createdBy
 * @property integer $updatedBy
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property Applicant[] $applicants
 */
class BaseCitizenship extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%citizenship}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'createdAt', 'updatedAt'], 'required'],
            [['createdBy', 'updatedBy', 'createdAt', 'updatedAt'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'createdBy' => Yii::t('app', 'Created By'),
            'updatedBy' => Yii::t('app', 'Updated By'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getApplicants()
    {
        return $this->hasMany(Applicant::className(), ['citizenshipId' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CitizenshipQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CitizenshipQuery(get_called_class());
    }

}