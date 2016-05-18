<?php

use backend\components\ButtonGroupColumn;
use backend\widgets\ActionButton;
use common\models\Account;
use common\models\Cinema;
use common\models\City;
use common\models\search\AccountSearch;
use common\widgets\Embedjs;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $provider ActiveDataProvider */
/* @var $searchModel AccountSearch */
?>


<h2><?= Yii::t('app', 'Account management') ?></h2>
<br/>

<p class="clearfix">
    <?= Html::a(Yii::t('app', 'Create a new Account'), ['create'], ['class' => 'btn btn-success pull-right']) ?>
</p>


<!-- grid -->
<?php
$roles = Account::roleList();
unset($roles[Account::ROLE_ADMIN]);

$loginCellTemplate = <<<EOT
{login}
<div style="padding-top: 10px">
    <div class="show-password">
        {button}
    </div>
    <span class="password-container bg-info" style="display:none">
        {password}
    </span>
</div>
EOT;

echo GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $searchModel,
    'condensed' => true,
    'floatHeader' => true,
    'pjax' => true,
    'columns' => [
        [
            'attribute' => 'username',
            'value' => function(Account $model) {
                return Html::a(Html::encode($model->username), ['update', 'id' => $model->id]);
            },
            'format' => 'raw',
            'width' => '170px',
        ],
        [
            'attribute' => 'position',
            'width' => '170px',
        ],
        [
            'attribute' => 'cityId',
            'header' => Yii::t('app', 'City'),
            'value' => function(Account $model) {
                $names = ArrayHelper::getColumn($model->cinemas, 'city.name', false);
                $names = array_unique($names);
                $names = array_diff($names, [null]); // remove nulls
                foreach ($names as &$name) {
                    $name = Html::encode($name);
                }
                return count($names) ? join("<br/> \n", $names) : '';
            },
            'format' => 'raw',
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['placeholder' => ' '],
                'data' => City::getList(),
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ],
            'width' => '170px',
        ],
        [
            'attribute' => 'cinemaId',
            'header' => Yii::t('app', 'Cinema'),
            'value' => function(Account $model) {
                $names = ArrayHelper::getColumn($model->cinemas, 'name', false);
                foreach ($names as &$name) {
                    $name = Html::encode($name);
                }
                return count($names) ? join("<br/> \n", $names) : '';
            },
            'format' => 'raw',
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['placeholder' => ' '],
                'data' => Cinema::getSelect2List(),
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ],
        ],
        [
            'attribute' => 'email',
            'header' => Yii::t('app', 'Login / Password'),
            'value' => function(Account $model) use($loginCellTemplate) {
                return strtr($loginCellTemplate, [
                    '{login}' => Html::encode($model->email),
                    '{button}' => ActionButton::widget([
                        'label' => Yii::t('app', 'Show password'),
                        'options' => ['class' => 'show-password'],
                    ]),
                    '{password}' => $model->publicPassword,
                ]);
            },
            'format' => 'raw',
            'width' => '120px',
        ],
        [
            'attribute' => 'role',
            'value' => function(Account $model) use ($roles) {
                return $roles[$model->role];
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['placeholder' => ' '],
                'data' => $roles,
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ],
            'width' => '120px',
        ],
        [
            'class' => ButtonGroupColumn::className(),
            'template' => '{update}{delete}',
            'width' => '110px',
        ],
    ],
]);
?>
<!-- /grid -->


<?php Embedjs::begin() ?>
<script>
    $(document).on('click', '.show-password', function () {
        var $button = $(this).hide();
        var $password = $(this).closest('tr').find('.password-container').show();
        setTimeout(function () {
            $button.show();
            $password.hide();
        }, 5000);
    });
</script>
<?php Embedjs::end() ?>

