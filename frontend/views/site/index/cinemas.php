<?php

use common\models\Applicant;
use common\models\Cinema;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model Applicant */
/* @var $cityId integer */
/* @var $metroId integer */

if ($metroId) {
    $cinemas = Cinema::find()
    ->joinWith([
        'metros',
        'vacancies',
    ])
    ->andWhere(['metro.id' => $metroId])
    ->andWhere('vacancy.id IS NOT NULL')
    ->all();
} else {
    $cinemas = Cinema::find()
    ->joinWith([
        'vacancies',
    ])
    ->andWhere('vacancy.id IS NOT NULL')
    ->all();
}
?>

<!-- applicant.cinemaId -->
<?=
$form->field($model, 'cinemaId', [
    'template' => '
        <div class="form_row">
            <div class="control-group radio_buttons required applicant_cinema">
                {label}
                <div class="controls">
                    {input}{error}{hint}
                </div>
            </div>
        </div>',
    'labelOptions' => [
        'class' => 'radio_buttons required control-label col-lg-12 col-md-12 col-xs-12 text-left',
    ],
    'options' => [
        'class' => 'row applicant_cinema_row expanded',
    ],
])
->radioList(ArrayHelper::map($cinemas, 'id', 'name'), [
    'tag' => false,
    'item' => function($index, $label, $name, $checked, $value) {
        $return = "
            <span class=\"radio\">
                <label>
                    <input class=\"radio_buttons required form-control\" name=\"{$name}\" type=\"radio\" value=\"{$value}\" style=\"display: none;\">
                    <a class=\"radio_button_theme input_theme\" ><div class=\"theme_inner\"></div></a>{$label}
                </label>
            </span>";
        return $return;
    }
])
?>
<!-- /applicant.cinemaId -->