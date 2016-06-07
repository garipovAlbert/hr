<?php

use common\models\Applicant;
use common\models\Citizenship;
use common\models\City;
use common\widgets\Embedjs;
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
                    <p class="title">Порядок предоставления Кандидатом персональных данных и условия получения рекламно-информационных сообщений:</p>
                    <ul>
                        <li>
                            1.1. При направлении анкеты Кандидата в ООО «КАРО Фильм Менеджмент» через настоящий сайт, Кандидат предоставляет следующую информацию, которая является персональными данными Кандидата: Фамилия, Имя, возраст, гражданство, номер мобильного телефона, адрес электронной почты и соглашается с нижеизложенным.
                        </li>
                        <li>
                            1.2. Предоставляя персональные данные через настоящий сайт, Кандидат соглашается на их обработку ООО «КАРО Фильм Менеджмент» в целях возможного трудоустройства в ООО «КАРО Фильм Менеджмент».
                        </li>
                        <li>
                            1.3. Перечень действий с персональными данными, на совершение которых дается согласие, общее описание используемых ООО «КАРО Фильм Менеджмент» способов обработки: получение, сбор, систематизация, накопление, обезличивание, блокирование, уничтожение персональных данных, в том числе у третьих лиц; хранение (в электронном виде и на бумажном носителе); уточнение (обновление, изменение) персональных данных; прием, передача персональных данных, в том числе трансграничный прием, передача (такой обмен прием, передача совершается без дополнительного оповещения Кандидата); любые иные действия.
                        </li>
                        <li>
                            1.4. Данные обрабатываются:с использованием средств автоматизации или без использования таких средств; с передачей и без по сетям связи общего доступа.
                        </li>
                        <li>
                            1.5. ООО «КАРО Фильм Менеджмент» вправе обрабатывать персональные данные Кандидата посредством внесения их в электронные базы данных, включения в списки (реестры), отчетные формы, а также любыми иными способами, соответствующими цели обработки.
                        </li>
                        <li>
                            1.6. Кандидат дает согласие на передачу его персональных данных компетентным государственным органам и федеральным учреждениям РФ по соответствующему письменному запросу таких органов и учреждений. Такая передача совершается без дополнительного оповещения Кандидата.
                        </li>
                        <li>
                            1.7. Разглашение информации, полученной ООО «КАРО Фильм Менеджмент»:
                            <ul>
                                <li>1.7.1. ООО «КАРО Фильм Менеджмент» обязуется не разглашать полученную от Кандидата информацию. Не считается нарушением предоставление Кандидатом информации агентам и третьим лицам, действующим на основании договора с ООО «КАРО Фильм Менеджмент».</li>
                                <li>1.7.2. Не считается нарушением обязательств разглашение информации в соответствии с обоснованными и применимыми требованиями закона.</li>
                            </ul>     
                        </li>
                        <li>
                            1.9. ООО «КАРО Фильм Менеджмент» вправе использовать технологию "cookies". "Cookies" не содержат конфиденциальную информацию и не передаются третьим лицам.
                        </li>
                        <li>
                            1.10. ООО «КАРО Фильм Менеджмент» получает информацию об ip-адресе посетителя (Кандидата) настоящего сайта. Данная информация не используется для установления личности посетителя (Кандидата).
                        </li>
                        <li>
                            1.11. Согласие Кандидата действует со дня предоставления персональных данных до отзыва согласия в письменной форме, после отзыва согласия персональные данные используются только в целях, предусмотренных законодательством.
                        </li>
                    </ul>
                </div>
                <div class="popups-close" onclick="closeModal();"></div>
            </div>

        </div>

    </div>
</div>



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

<div class="container">
    <div class="page_descr"><div class="row text-center">
            <h1 class="second_label">Заполни анкету прямо сейчас!</h1>
        </div>
        <div class="row text-center description">
            Если вы молоды, энергичны и любите кино, приходите работать и строить свою карьеру в КАРО!
        </div>                        
    </div>  
</div>



<div class="form-group has-error row">
    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="apply_form col-lg-10 col-md-10 col-sm-10">
                <div class="work_in_karo_block">
                    <div class="block_title semibold_text">Работа в КАРО — это:</div>
                    <div class="pluses_block row">
                        <div class="work_in_karo_item icon_clock col-lg-6 col-md-6 col-sm-12 col-xs-12">Гибкий график</div>
                        <div class="work_in_karo_item icon_square_cap col-lg-6 col-md-6 col-sm-12 col-xs-12">Перспективы и возможность карьерного роста</div>
                        <div class="work_in_karo_item icon_map_markers col-lg-6 col-md-6 col-sm-12 col-xs-12">Более 30 кинотеатров в России</div>
                        <div class="work_in_karo_item last icon_scales col-lg-6 col-md-6 col-sm-12 col-xs-12">Официальное трудоустройство</div>
                        <div class="work_in_karo_item icon_briefcase col-lg-6 col-md-6 col-sm-12 col-xs-12">Конкурентная заработная плата</div>
                    </div>
                    <div class="vacancies_in_karo_block row">
                        <div class="vacancies_open">
                            <span class="semibold_text">У нас открыты вакансии: </span>
                            <span class="vacancies_list"><a data-target="#vacancy_description_20" data-toggle="modal" href="http://hr.karofilm.ru/#">Контролер-кассир.</a> </span>
                        </div>
                        <div class="vacancy_condition">
                            <span class="semibold_text">Ты можешь работать в КАРО, если: </span>ты гражданин РФ или Белоруссии; тебе исполнилось 18 лет.
                        </div>
                    </div>
                </div>
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
                                        <div class="seven" style="float:left">+7</div>
                                        <div style="margin-left: 50px">{input}</div>
                                        <div style="clear:both">{error}{hint}</div>
                                    </div>
                                </div>
                            </div>
                        </div>',
                        'labelOptions' => [
                            'class' => 'select required control-label col-lg-5 col-md-5 col-xs-5 text-left',
                        ],
                    ])
                    ->textInput()
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








    window.closeModal = function () {
        $(".modal.fade.in").click()
    }

</script>
<?php Embedjs::end(); ?>