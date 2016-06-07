<?php

namespace common\models\gii;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sms_log}}".
 *
 * @property integer $id
 * @property string $result
 * @property string $code
 * @property string $message
 * @property string $description
 * @property string $smsId
 * @property string $phone
 */
class BaseSmsLog extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sms_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['result', 'code', 'message', 'description'], 'string'],
            [['smsId', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'result' => Yii::t('app', 'Result'),
            'code' => Yii::t('app', 'Code'),
            'message' => Yii::t('app', 'Message'),
            'description' => Yii::t('app', 'Description'),
            'smsId' => Yii::t('app', 'Sms ID'),
            'phone' => Yii::t('app', 'Phone'),
        ];
    }

}