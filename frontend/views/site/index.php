<?php

use common\models\Applicant;
use common\models\Citizenship;
use common\models\City;
use common\widgets\Embedjs;
use frontend\widgets\phone\Phone;
use yii2mod\chosen\ChosenSelect;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Applicant */
/* @var $cities City[] */

BootstrapPluginAsset::register($this);
?>

<div class="modal_vertical_center modal fade" id="success-applicant" tabindex="-1" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content modal_content_agreement">
            <div id="agreement_modal">
                <div class="agreement_text">
                    <p class="title">СОГЛАСИЕ КАНДИДАТА НА ОБРАБОТКУ ПЕРСОНАЛЬНЫХ ДАННЫХ</p>
                    <ul>
                        <li>
                            Я своей волей и в своем интересе даю согласие на обработку обществом с ограниченной ответственностью «КАРО Фильм Менеджмент» (119019, г. Москва, ул. Новый Арбат, д. 24) (далее – «Компания КАРО») моих персональных данных, указанных в форме на сайте www.hr.karofilm.ru и / или в приложенном резюме, а также на передачу Компанией КАРО моих персональных данных третьим лицам, привлекаемым Компанией КАРО для целей, связанных с  моим трудоустройством.
                        </li>
                        <li>
                            Цель обработки персональных данных: <br/>
                            - осуществление Компанией КАРО любых контактов со мной по вопросам предложения вакансий, дальнейшего трудоустройства;<br/>
                            - проведение собеседований и принятие решения о приеме либо отказе в приеме меня на работу в Компанию КАРО;<br/>
                            - включение меня в кадровый резерв Компании КАРО.<br/>
                        </li>
                        <li>
                            Перечень персональных данных, подлежащих обработке, указан в заполняемой мной форме на сайте www.hr.karofilm.ru и/или в приложенном резюме, и в том числе содержит следующие данные: фамилия, имя, возраст, гражданство, номер мобильного телефона, адрес электронной почты.
                        </li>
                        <li>
                            Способы обработки персональных данных: сбор, запись, систематизация, накопление, хранение, уточнение (обновление, изменение), извлечение, использование, передача (распространение, предоставление, доступ), блокирование, обезличивание, удаление и уничтожение персональных данных, совершение иных действий (операций) с персональными данными, совершаемых с использованием средств автоматизации и без использования таких средств (неавтоматизированная обработка).
                        </li>
                        <li>
                            Настоящим заверяю и гарантирую, что (i) данные, указанные в форме на сайте www.hr.karofilm.ru и/или в приложенном резюме являются достоверными, (ii) я являюсь законным пользователем (абонентом)  адреса электронной почты и номера мобильного телефона, которые указаны мной в форме на сайте www.hr.karofilm.ru, и обязуюсь возместить компании КАРО любой ущерб, причиненный в связи с недостоверностью указанных мной данных и/или нарушением предоставленных заверений и гарантий.
                        </li>
                        <li>
                            Настоящее согласие действует в течение пяти лет со дня его предоставления.
                        </li>
                        <li>
                            Я уведомлен и согласен(-а) с тем, что вправе отозвать согласие на обработку персональных данных путем направления письменного обращения к Компании КАРО по адресу места нахождения:  119019, г. Москва, ул. Новый Арбат, д. 24 либо по адресу электронной почты: hr@karofilm.ru (указав тему письма «КАРО СТОП»).
                        </li>
                    </ul>
                </div>
                <div class="popups-close" onclick="closeModal();"></div>
            </div>

        </div>

    </div>
</div>


<h3>Заполни онлайн-заявку прямо сейчас!</h3>
<p><span>Если вы молоды, энергичны и любите кино, </span>
    <span>приходите работать и строить свою карьеру в КАРО!</span></p>
<h3>Работа в КАРО — это:</h3>
<div class="slider-offer">
    <ul class="owl-carousel">
        <li>
            <img src="/img/icons/1.png" alt="">
            Гибкий график
        </li>
        <li>
            <img src="/img/icons/4.png" alt="">
            28 кинотеатров
        </li>
        <li>
            <img src="/img/icons/2.png" alt="">
            Конкурентная <br>
            заработная плата
        </li>
        <li>
            <img src="/img/icons/3.png" alt="">
            Официальное <br>
            трудоустройство
        </li>
        <li>
            <img src="/img/icons/5.png" alt="">
            Перспективы и возможность карьерного роста
        </li>
    </ul>
</div>  
<div class="inner-content">
    <h4>У нас открыты вакансии:</h4>
    <ul class="vacancy-list">
        <li>
            <h5><a href="#">Контролер-кассир</a></h5>
        </li>
    </ul>
    <p>
        Ты можешь работать в КАРО, если: ты гражданин <br>
        РФ или Белоруссии; тебе исполнилось 18 лет.
    </p>
    <div class="separator"></div>
    <div>

        <?php
        /* @var $form ActiveForm */
        $form = ActiveForm::begin([
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'options' => [
                'class' => 'simple_form new_applicant',
                'role' => 'form',
            ],
            'id' => 'new_applicant',
        ]);
        ?>

        <div class="form-group has-error row">
            <div class="container-fluid">
                <div>
                    <div class="apply_form">
                        <div class="form-inputs row">
                            <div class="row">
                                <div class="title text-center">Личная информация</div>                                        
                            </div>



                            <!-- /applicant.lastName -->
                            <?=
                            $form->field($model, 'lastName', [
                                'template' => '
                                <div class="row">
                                    <div class="form_row">
                                        <div class="control-group string required applicant_name">
                                            {label}
                                             <div class="controls">
                                                {input}{error}{hint}
                                            </div>
                                        </div>
                                    </div>
                                </div>',
                                'labelOptions' => [
                                    'class' => 'string required control-label col-lg-5 col-md-5 col-xs-5 text-left',
                                ],
                            ])
                            ->textInput()
                            ?>
                            <!-- /applicant.lastName -->



                            <!-- applicant.firstName -->
                            <?=
                            $form->field($model, 'firstName', [
                                'template' => '
                                <div class="row">
                                    <div class="form_row">
                                        <div class="control-group string required applicant_name">
                                            {label}
                                             <div class="controls">
                                                {input}{error}{hint}
                                            </div>
                                        </div>
                                    </div>
                                </div>',
                                'labelOptions' => [
                                    'class' => 'string required control-label col-lg-5 col-md-5 col-xs-5 text-left',
                                ],
                            ])
                            ->textInput()
                            ?>
                            <!-- /applicant.firstName -->



                            <!-- applicant.age -->
                            <?=
                            $form->field($model, 'age', [
                                'template' => '
                                <div class="row">
                                    <div class="form_row">
                                        <div class="control-group string required applicant_name">
                                            {label}
                                            <div class="controls">
                                                {input}{error}{hint}
                                            </div>
                                        </div>
                                    </div>
                                </div>',
                            ])
                            ->widget(ChosenSelect::className(), [
                                'items' => ['' => ''] + array_combine(range(18, 60), range(18, 60)),
                                'options' => ['data-placeholder' => ' ', 'multiple' => false],
                                'pluginOptions' => [
                                    'disable_search_threshold' => 2,
                                    'disable_search' => true,
                                    'width' => '200px',
                                ],
                            ]);
                            ?>
                            <!-- /applicant.age -->



                            <!-- applicant.citizenshipId -->
                            <?=
                            $form->field($model, 'citizenshipId', [
                                'template' => '
                                <div class="row">
                                    <div class="form_row">
                                        <div class="control-group radio_buttons string required applicant_citizenship">
                                            {label}
                                            <div class="controls">
                                                {input}{error}{hint}
                                            </div>
                                        </div>
                                    </div>
                                </div>',
                                'labelOptions' => [
                                    'class' => 'radio_buttons required control-label col-lg-5 col-md-5 col-xs-5 text-left',
                                ],
                            ])
                            ->radioList(Citizenship::getList(), [
                                'item' => function($index, $label, $name, $checked, $value) {
                                    $return = "
                                    <span class=\"radio\">
                                        <label>
                                            <input class=\"radio_buttons required form-control\" name=\"{$name}\" type=\"radio\" value=\"{$value}\" style=\"display: none;\">
                                            <a date-input-id=\"applicant_citizenship_id_1\" class=\"radio_button_theme input_theme\" ><div class=\"theme_inner\"></div></a>{$label}
                                        </label>
                                    </span>
                                    ";
                                    return $return;
                                }
                            ])
                            ?>
                            <!-- /applicant.citizenshipId -->



                            <!-- applicant.phone -->
                            <?=
                            $form->field($model, 'phone', [
                                'template' => '
                                <div class="row">
                                    <div class="form_row">
                                        <div class="control-group string required applicant_name">
                                            {label}
                                            <div class="controls">
                                                {input}{error}{hint}
                                            </div>
                                        </div>
                                    </div>
                                </div>',
                                'labelOptions' => [
                                    'class' => 'select required control-label col-lg-5 col-md-5 col-xs-5 text-left',
                                ],
                                'enableClientValidation' => false,
                            ])
                            ->widget(Phone::className())
                            ?>
                            <!-- /applicant.phone -->



                            <!-- applicant.email -->
                            <?=
                            $form->field($model, 'email', [
                                'template' => '
                                <div class="row">
                                    <div class="form_row">
                                        <div class="control-group string required applicant_name">
                                            {label}
                                             <div class="controls">
                                                {input}{error}{hint}
                                            </div>
                                        </div>
                                    </div>
                                </div>',
                                'labelOptions' => [
                                    'class' => 'string required control-label col-lg-5 col-md-5 col-xs-5 text-left',
                                ],
                            ])
                            ->textInput()
                            ?>
                            <!-- /applicant.email -->



                            <!-- applicant.info -->
                            <?=
                            $form->field($model, 'info', [
                                'template' => '
                                <div class="row">
                                    <div class="form_row">
                                        <div class="control-group string applicant_info_from">
                                            {label}
                                             <div class="controls">
                                                {input}{error}{hint}
                                            </div>
                                        </div>
                                    </div>
                                </div>',
                                'labelOptions' => [
                                    'class' => 'control-label col-lg-5 col-md-5 col-xs-5 text-left',
                                ],
                            ])
                            ->textarea()
                            ?>
                            <!-- /applicant.info -->

                        </div>
                        <div class="form-inputs row place_work">
                            <div class="row">
                                <div class="title text-center">Желаемое место работы</div>                                  
                            </div>

                            <!-- applicant.citizenshipId -->
                            <?=
                            $form->field($model, 'cityId', [
                                'template' => '
                                <div class="form_row">
                                    <div class="control-group radio_buttons required applicant_city">
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
                                    'class' => 'row applicant_city_row expanded',
                                ],
                            ])
                            ->radioList(ArrayHelper::map($cities, 'id', 'name'), [
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
                            <!-- /applicant.citizenshipId -->

                            <div class="js-metro-container row"></div>
                            <div class="js-cinema-container row"></div>
                            <div class="js-vacancy-container row"></div>


                            <div class="agreement row">
                                <div class="form_row">
                                    <div class="agreement_wrapper">
                                        <input id="accept" name="accept" type="checkbox" value="0" style="display: none;">
                                        <a date-input-id="accept" class="checkbox_button_theme input_theme"><div class="theme_inner"></div></a>
                                        <label for="accept">
                                            Нажимая кнопку "Отправить", я подтверждаю свою дееспособность, даю согласие на обработку своих персональных данных ООО «КАРО Фильм Менеджмент» 
                                            <br/>
                                            <a class="open_agreement" data-target="#success-applicant" data-toggle="modal" href="#">на следующих условиях</a>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions row">
                            <div class="text-center">
                                <input class="btn disabled apply_page_link" data-disable-with="Отправка..." disabled="disabled" name="commit" type="submit" value="Отправить">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>



<?php
$hasMetros = [];
foreach ($cities as $city) {
    if (count($city->metros)) {
        $hasMetros[] = $city->id;
    }
}
Embedjs::begin([
    'data' => [
        'hasMetros' => $hasMetros,
        'loadMetrosUrl' => Url::to(['load-metros']),
        'loadCinemasUrl' => Url::to(['load-cinemas']),
        'loadVacanciesUrl' => Url::to(['load-vacancies']),
        'cityInputName' => Html::getInputName($model, 'cityId'),
        'metroInputName' => Html::getInputName($model, 'metroId'),
        'cinemaInputName' => Html::getInputName($model, 'cinemaId'),
        'vacancyInputName' => Html::getInputName($model, 'vacancyId'),
    ],
]);
?>
<script>

    data.hasMetros.indexOf(+'8');

    var updateSubmitButton = function () {
        var selected = !!$('[name = "' + data.vacancyInputName + '"]:checked').val();
        var checked = $('[name="accept"]').is(':checked');

        if (selected && checked) {
            $('.apply_page_link').removeClass('disabled').removeAttr('disabled');
        } else {
            $('.apply_page_link').addClass('disabled').attr('disabled', 'disabled');
        }
    };


    $('[name="accept"]').change(function () {
        updateSubmitButton();
    });


    $(document).on('change', '[name="' + data.cityInputName + '"]', function (e) {
        var cityId = +$(this).val();

        if (data.hasMetros.indexOf(+cityId) !== -1) {
            $.get(data.loadMetrosUrl, {cityId: cityId}, function (response) {
                var html = $('<div>' + response + '</div>');
                $('.js-metro-container').html(html.find('.applicant_subway_station_row'));
            });
        } else {
            $('.js-metro-container').empty();
        }

        $.get(data.loadCinemasUrl, {cityId: cityId}, function (response) {
            var html = $('<div>' + response + '</div>');
            $('.js-cinema-container').html(html.find('.applicant_cinema_row'));
        });

        $('.js-vacancy-container').empty();

        updateSubmitButton();
    });

    $(document).on('change', '[name="' + data.metroInputName + '"]', function (e) {
        var metroId = +$(this).val();

        $.get(data.loadCinemasUrl, {metroId: metroId}, function (response) {
            var html = $('<div>' + response + '</div>');
            $('.js-cinema-container').html(html.find('.applicant_cinema_row'));
        });

        $('.js-vacancy-container').empty();

        updateSubmitButton();
    });

    $(document).on('change', '[name = "' + data.cinemaInputName + '"]', function (e) {
        var cinemaId = +$(this).val();

        $.get(data.loadVacanciesUrl, {cinemaId: cinemaId}, function (response) {
            var html = $('<div>' + response + '</div>');
            $('.js-vacancy-container').html(html.find('.applicant_vacancy_row'));
        });

        updateSubmitButton();
    });

    $(document).on('change', '[name = "' + data.vacancyInputName + '"]', function (e) {
        updateSubmitButton();
    });





    $(document).on('change', '.js-cinema-button', function (e) {
        if ($(this).is(':checked')) {

            var ids = ($(this).data('metro-ids')+'').split(',');
            var $checked = $('.js-metro-button:checked');

            if ($checked.length === 0 || ids.indexOf($checked.data('id') + '') === -1) {
                $('.js-metro-button').prop('checked', false);
                if (ids.length) {
                    $('.js-metro-button[data-id=' + ids[0] + ']').prop('checked', true);
                }
            }

        }
    });



    window.closeModal = function () {
        $(".modal.fade.in").click()
    }


    $('.agreement_wrapper .checkbox_button_theme').click(function () {
        $(this).closest('.agreement_wrapper').find('input').click();
    });

</script>
<?php Embedjs::end(); ?>