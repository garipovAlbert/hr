<?php

namespace frontend\widgets\phone;

use yii\widgets\InputWidget;

/**
 * Phone widget.
 */
class Phone extends InputWidget
{

    /**
     * @var string
     */
    public $codeAttribute = 'phoneCode';

    /**
     * @var string
     */
    public $numberAttribute = 'phoneNumber';

    public function run()
    {
        return $this->render('phone', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'codeAttribute' => $this->codeAttribute,
            'numberAttribute' => $this->numberAttribute,
        ]);
    }

}