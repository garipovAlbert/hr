<?php

use common\widgets\Embedjs;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
?>

<div class="new_applicant">
    <div class="container">
        <div class="page_descr">
            <div class="row text-center">
                <h1 class="second_label">Заполни анкету прямо сейчас!</h1></div>
            <div class="row text-center description">Если вы молоды, энергичны и любите кино, приходите работать и строить свою карьеру в КАРО!</div>
        </div>
    </div>
    <div class="confirmation_applicant_form_block success_block row">
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="confirmation_applicant_form col-lg-10 col-md-10 col-sm-10">
                    <div class="title text-center">Подтвердите отправление анкеты</div>
                    <div class="confirmation_applicant_form_description text-center">Мы выслали смс-сообщение с кодом подтверждния на указанный вами номер телефона: +7 (919) 1486150. Внесите его в поле ниже, нажмите кнопку “Подтвердить” и ваша анкета будет отправлена.</div>

                    <?php
                    /* @var $form ActiveForm */
                    $form = ActiveForm::begin([
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'options' => [
                            'class' => 'simple_form edit_applicant',
                            'role' => 'form',
                            'autocomplete' => 'off',
                        ],
                        'id' => 'new_applicant',
                    ]);
                    ?>
                    <!--<form accept-charset="UTF-8" action="/check_verification_code" class="simple_form edit_applicant" data-remote="true" id="edit_applicant_37153" method="post" novalidate="novalidate">-->


                    <!-- applicant.confirmationInput -->
                    <?=
                    $form->field($model, 'confirmationInput', [
                        'template' => '
                        
                            <div class="form_row">
                                <div class="control-group string required applicant_verification_code_confirm">
                                    {label}
                                     <div class="controls">
                                        {input}
                                    </div>
                                    {error}{hint}
                                </div>
                            </div>
                        ',
                        'labelOptions' => [
                            'class' => 'string required control-label',
                        ],
                        'options' => [
                            'class' => 'row sms_code_block',
                        ],
                    ])
                    ->textInput()
                    ?>
                    <!-- /applicant.confirmationInput -->

                    <div class="form-actions row">
                        <div class="text-center"><input class="btn apply_page_link" disabled="" name="commit" type="submit" value="Подтвердить"></div>
                    </div>
                    <!--</form>-->
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
Embedjs::begin([
    'data' => [
        'confirmationInputName' => Html::getInputName($model, 'confirmationInput'),
    ],
]);
?>
<script>



    $('[name = "' + data.confirmationInputName + '"]').on('change keyup click', function () {
        var val = $(this).val().trim();
        if (val) {
            $('.apply_page_link').removeClass('disabled').removeAttr('disabled');
        } else {
            $('.apply_page_link').addClass('disabled').attr('disabled', 'disabled');
        }
    }).change();
</script>
<?php Embedjs::end(); ?>