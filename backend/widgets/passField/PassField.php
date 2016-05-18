<?php

namespace backend\widgets\passField;

use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Виджет для поля формы с паролем.
 * @link http://antelle.github.io/passfield/index.html Страница jQuery плагина Pass*Field.
 * @link https://github.com/antelle/passfield Страница плагина в Github.
 */
class PassField extends \yii\widgets\InputWidget
{

    public $clientOptions = [];

    public function run()
    {
        PassAsset::register($this->getView());

        $id = Html::getInputId($this->model, $this->attribute);
        $jsOptions = Json::encode($this->clientOptions);
        $this->getView()->registerJs("$('#{$id}').passField({$jsOptions});");

        return Html::activeTextInput($this->model, $this->attribute, [
            'class' => 'form-control',
            'autocomplete' => 'off',
        ]);
    }

}