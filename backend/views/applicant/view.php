<?php

use common\models\Applicant;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
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


<div style="max-width: 900px">
    <?php
    echo DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="width:150px">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'name',
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
                        'data' => v(Applicant::statusList()),
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
            'formattedPhone',
            'email',
            'info',
        ],
    ])
    ?>
</div>