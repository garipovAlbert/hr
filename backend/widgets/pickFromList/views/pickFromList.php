<?php

use common\widgets\Embedjs;
use kartik\grid\GridView;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $searchGridConfig array */
/* @var $linkedGridConfig array */
/* @var $id string */
/* @var $model Model */
/* @var $attribute string */
/* @var $inputId string */

$pjaxId = 'pickFromList-' . $id;
?>

<?=
Html::activeHiddenInput($model, $attribute, [
    'value' => is_array($model->{$attribute}) ? join(',', $model->{$attribute}) : $model->{$attribute},
]);
?>

<?php
Pjax::begin([
    'id' => $pjaxId,
    'clientOptions' => [
        'push' => false,
        'scrollTo' => false,
    ],
]);
?>

<div id="<?= $id ?>">

    <div class="container-fluid">

        <div class="col-md-7">
            <?= GridView::widget($searchGridConfig) ?>
        </div>

        <div class="col-md-5">
            <?= GridView::widget($linkedGridConfig) ?>
        </div>

    </div>

</div>

<?php
Embedjs::begin([
    'data' => [
        'inputId' => $inputId,
        'searchGridId' => $searchGridConfig['id'],
        'linkedGridId' => $linkedGridConfig['id'],
        'widgetId' => $id,
        'value' => $model->{$attribute},
        'pjaxId' => $pjaxId,
    ],
])
?>
<script>

    var $searchGrid = $('#' + data.searchGridId);
    var $linkedGrid = $('#' + data.linkedGridId);

    var $input = $('#' + data.inputId);
    var val = $input.val();
    var ids = val.length === 0 ? [] : val.split(',');

    var serialize = function (obj) {
        var str = [];
        for (var p in obj)
            if (obj.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    };


    var settings = $('#' + data.searchGridId).yiiGridView('data').settings;

    var index = settings.filterUrl.indexOf('?');
    var filterScriptName = index !== -1 ? settings.filterUrl.substring(0, index) : settings.filterUrl;


    var refresh = function () {

        var params = {};

        $.each($(settings.filterSelector).serializeArray(), function () {
            params[this.name] = this.value;
        });

        $.each(yii.getQueryParams(settings.filterUrl), function (name, value) {
            if (params[name] === undefined) {
                params[name] = value;
            }
        });

        params.linkedIds = ids;

        var url = filterScriptName + '?' + serialize(params);

        $.pjax({
            url: url,
            container: '#' + data.pjaxId,
            push: false,
            scrollTo: false
        });

    };

    $searchGrid.on('click', '[data-add]', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        if (ids.indexOf(id) === -1) {
            ids.push(id);
            $input.val(ids.join(','));
            refresh();
        }
    });

    $linkedGrid.on('click', '[data-remove]', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var index = ids.indexOf(id);
        if (index !== -1) {
            // remove id from ids
            ids.splice(index, 1);
            $input.val(ids.join(','));
            refresh();
        }
    });




    var enterPressed = false;
    $(document).off('change.yiiGridView keydown.yiiGridView', settings.filterSelector)
        .on('change.yiiGridView keydown.yiiGridView', settings.filterSelector, function (event) {

            if (event.type === 'keydown') {
                if (event.keyCode !== 13) {
                    return; // only react to enter key
                } else {
                    event.preventDefault();
                    enterPressed = true;
                }
            } else {
                // prevent processing for both keydown and change events
                if (enterPressed) {
                    enterPressed = false;
                    return;
                }
            }
            refresh();
        });

</script>
<?php Embedjs::end() ?>


<?php Pjax::end(); ?>