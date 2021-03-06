<?php

namespace common\widgets;

use yii\helpers\Json;
use yii\web\View;
use yii\widgets\Block;

/**
 * @link https://github.com/mitrii/yii2-embedjs
 */
class Embedjs extends Block
{

    public $position = View::POS_READY;
    public $key;
    public $data;

//    static function begin($config = [])
//    {
//        parent::begin(is_array($config) ? $config : ['position' => $config]);
//    }

    public function run()
    {
        $block = trim(ob_get_clean());

        $jsBlockPattern = '|^<script[^>]*>(?P<block_content>.+?)</script>$|is';
        if (preg_match($jsBlockPattern, $block, $m)) {
            $block = $m['block_content'];
        }

        if ($this->data !== null) {
            $jsData = Json::encode($this->data);
            $block = "(function(data){\n{$block}\n}($jsData));\n";
        }

        $key = (empty($this->key)) ? md5($block) : $this->key;

        $this->view->registerJs($block, $this->position, $key);
    }

}