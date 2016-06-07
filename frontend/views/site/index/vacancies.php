<?php

use common\models\Vacancy;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this View */
/* @var $cinemaId integer */

$vacancies = Vacancy::find()
->joinWith('cinemas')
->andWhere(['cinema.id' => $cinemaId])
->all();
?>

<!-- applicant.vacancyId -->
<?=
$form->field($model, 'vacancyId', [
    'template' => '
    <div class="form_row">
        <div class="control-group radio_buttons required applicant_vacancy">
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
        'class' => 'row applicant_vacancy_row expanded',
    ],
])
->radioList(ArrayHelper::map($vacancies, 'id', 'name'), [
    'tag' => false,
    'item' => function($index, $label, $name, $checked, $value) {
        $return = "
            <span class=\"radio\">
                <label>
                    <input class=\"radio_buttons required form-control\" name=\"{$name}\" type=\"radio\" value=\"{$value}\" style=\"display: none;\">
                    <a class=\"radio_button_theme input_theme\" ><div class=\"theme_inner\"></div></a>{$label}
                </label>
            </span>
        ";
        return $return;
    }
])
?>
<!-- /applicant.vacancyId -->