<?php

namespace backend\components;

use backend\widgets\ActionButton;
use kartik\grid\ActionColumn;
use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class ButtonGroupColumn extends ActionColumn 
{

    public $headerOptions = ['style' => 'width: 120px;'];
    public $contentOptions = ['style' => 'text-align: center;'];

    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = [$this, 'viewButton'];
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = [$this, 'updateButton'];
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = [$this, 'deleteButton'];
        }
    }

    /**
     * @param string|array $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function viewButton($url, $model, $key)
    {
        $options = array_merge([
            'title' => Yii::t('yii', 'View'),
            'aria-label' => Yii::t('yii', 'View'),
            'data-pjax' => '0',
        ], $this->buttonOptions);

        return ActionButton::widget([
            'url' => $url,
            'glyphicon' => 'eye-open',
            'options' => $options,
            'type' => 'info sm',
        ]);
    }

    /**
     * @param string|array $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function updateButton($url, $model, $key)
    {
        $options = array_merge([
            'title' => Yii::t('yii', 'Update'),
            'aria-label' => Yii::t('yii', 'Update'),
            'data-pjax' => '0',
        ], $this->buttonOptions);

        return ActionButton::widget([
            'url' => $url,
            'glyphicon' => 'pencil',
            'options' => $options,
            'type' => 'warning sm',
        ]);
    }

    /**
     * @param string|array $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function deleteButton($url, $model, $key)
    {
        $options = array_merge([
            'title' => Yii::t('yii', 'Delete'),
            'aria-label' => Yii::t('yii', 'Delete'),
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'data-pjax' => '0',
        ], $this->buttonOptions);

        return ActionButton::widget([
            'url' => $url,
            'glyphicon' => 'trash',
            'options' => $options,
            'type' => 'danger sm',
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return Html::tag('span', parent::renderDataCellContent($model, $key, $index), [
            'class' => 'btn-group',
            'role' => 'group',
            'aria-label' => '...',
        ]);
    }

}