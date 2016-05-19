<?php

use common\models\Applicant;
use common\models\Cinema;
use common\models\Citizenship;
use common\models\Vacancy;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Applicant */
/* @var $form ActiveForm */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
//        'options' => [
//            'autocomplete' => 'off',
//        ],
        'id' => 'create-form',
    ]);
    ?>

    <div class="container-fluid">
        <div class="col-md-6">

            <?= $form->field($model, 'firstName')->textInput() ?>

            <?= $form->field($model, 'lastName')->textInput() ?>

            <?php
            $items = array_combine(range(18, 60), range(18, 60));
            echo $form->field($model, 'age')->dropDownList($items, ['prompt' => '']);
            ?>

            <?= $form->field($model, 'citizenshipId')->radioList(Citizenship::getList()) ?>

            <?= $form->field($model, 'phone')->textInput() ?>

            <?= $form->field($model, 'email')->textInput() ?>

            <?= $form->field($model, 'info')->textarea() ?>

            <?php
            echo $form->field($model, 'cinemaId')
            ->widget(Select2::classname(), [
                'data' => Cinema::getSelect2List(),
                'language' => 'ru',
                'options' => ['placeholder' => ' '],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]);
            ?>

            <?php
            echo $form->field($model, 'vacancyId')
            ->widget(Select2::classname(), [
                'data' => Vacancy::getList(),
                'language' => 'ru',
                'options' => ['placeholder' => ' '],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]);
            ?>

        </div>
    </div>

    <hr/>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
