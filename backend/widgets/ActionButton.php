<?php

namespace backend\widgets;

use yii\bootstrap\Button;
use yii\helpers\Html;

/**
 * Adds button type and icon.
 * 
 * @author Albert Garipov <bert320@gmail.com>
 */
class ActionButton extends Button
{

    /**
     * For example, ['danger', 'sm'] or 'info lg';
     * @var array|string
     */
    public $type = 'default';
    public $iconClass;
    public $glyphicon;
    public $label = '';
    public $encodeLabel = false;
    public $url = false;

    public function init()
    {
        parent::init();

        if (is_array($this->type)) {
            $classes = $this->type;
        } else {
            $classes = explode(' ', $this->type);
        }
        foreach ($classes as $class) {
            Html::addCssClass($this->options, 'btn-' . $class);
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        if ($this->glyphicon !== null) {
            $this->iconClass = 'glyphicon glyphicon-' . $this->glyphicon;
        }

        if ($this->iconClass !== null) {
            $icon = Html::tag('span', '', [
                'class' => $this->iconClass,
            ]) . ' ';
        } else {
            $icon = '';
        }

        $content = $this->encodeLabel ? Html::encode($this->label) : $this->label;

        if ($this->url) {
            echo Html::a($icon . $content, $this->url, $this->options);
        } else {
            echo Html::tag($this->tagName, $icon . $content, $this->options);
        }

        $this->registerPlugin('button');
    }

}