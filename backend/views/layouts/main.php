<?php

use common\widgets\Alert;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/* @var $this View */
/* @var $content string */
?>


<?php $this->beginContent('@app/views/layouts/base.php'); ?>



<div class="container">

    <div class="col-md-12 content-area">
        <?=
        Breadcrumbs::widget([
            'homeLink' => false,
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])
        ?>

        <?= Alert::widget() ?>

        <?= $content ?>
    </div>

</div>

<?php $this->endContent(); ?>