<?php

namespace backend\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class ViewHelper
{

    public static function getMultipleLabel(array $models, $attr = 'name')
    {
        $result = [];
        foreach (ArrayHelper::getColumn($models, $attr) as $val) {
            $result[] = Html::encode($val);
        }

        return count($result) ? join("<br/> \n", $result) : '';
    }

    /**
     * Returns an array used in Select2 widget.
     * @param array $list Key-value array.
     * @return array
     */
    public static function getSelect2Data($list)
    {
        $result = [];
        foreach ($list as $id => $text) {
            $result[] = ['id' => $id, 'text' => $text];
        }
        return $result;
    }

    /**
     * @param boolean $value
     * @return string Icon HTML.
     */
    public static function getBooleanIcon($value)
    {
        return Html::tag('span', '', [
            'class' => 'glyphicon ' . ($value ? 'glyphicon-ok text-success' : 'glyphicon-remove text-danger'),
        ]);
    }

}