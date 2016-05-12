<?php

namespace backend\components;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Controller as baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
abstract class Controller extends baseController
{

    /**
     * @param ActiveRecord|array $models
     * @return array
     */
    protected function ajaxValidate($models)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (is_array($models)) {
            return ActiveForm::validateMultiple($models);
        } else {
            return ActiveForm::validate($models);
        }
    }

}