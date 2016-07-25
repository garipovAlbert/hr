<?php

use common\models\Applicant;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $model Applicant */

$this->title = Yii::t('app', 'Applications') . ' - ' . $model->name;

$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('app', 'Applications'),
        'url' => ['index'],
    ],
    $model->name,
];
?>


<h2><?= Yii::t('app', 'Application') ?>. <?= Html::encode($model->name) ?></h2>
<br/>

<div>
    <?php
    echo DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="width:150px">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => Editable::widget([
                    'model' => $model,
                    'attribute' => 'status',
                    'formOptions' => ['action' => ['update-ajax', 'id' => $model->id]],
                    'inputType' => Editable::INPUT_SELECT2,
                    'displayValue' => ArrayHelper::getValue(Applicant::statusList(), $model->status),
                    'options' => [
                        'data' => Applicant::statusListSet(),
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                        'pluginEvents' => [
                            'select2:select' => "function() { console.log('select'); }",
                        ],
                    ],
//                    'size' => 'md',
//                    'format' => 'button',
//                    'editableValueOptions' => ['class' => 'well well-sm']
                ]),
            ],
            'createdAt:date',
            [
                'attribute' => 'cinema.name',
                'label' => Yii::t('app', 'Cinema'),
            ],
            'age',
            [
                'attribute' => 'citizenship.name',
                'label' => Yii::t('app', 'Citizenship'),
            ],
            [
                'attribute' => 'formattedPhone',
                'value' => Html::a(Html::encode($model->formattedPhone), 'tel:' . $model->formattedPhone),
                'format' => 'raw',
            ],
            [
                'attribute' => 'email',
                'value' => Html::a(Html::encode($model->email), 'mailto:' . $model->email),
                'format' => 'raw',
            ],
            'info',
        ],
    ])
    ?>
</div>