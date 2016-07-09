<?php

use yii\db\ActiveRecord;
use yii\web\View;
use yii\widgets\MaskedInput;

/* @var $this View */
/* @var $model ActiveRecord */
/* @var $attribute string */
/* @var $codeAttribute string */
/* @var $numberAttribute string */
?>

<div>
    <div class="seven" style="float:left">+7</div>
    <div style="float:left; width:70px; margin-left: 12px">
        <?=
        MaskedInput::widget([
            'model' => $model,
            'attribute' => $codeAttribute,
            'mask' => '999',
            'options' => [
                'class' => 'form-control',
                'style' => 'text-align: center'
            ],
        ]);
        ?>
    </div>
    <div style="margin-left: 120px;">
        <?=
        MaskedInput::widget([
            'model' => $model,
            'attribute' => $numberAttribute,
            'mask' => '999-99-99',
            'options' => [
                'class' => 'form-control',
                'style' => 'text-align: center'
            ],
        ]);
        ?>
    </div>

</div>