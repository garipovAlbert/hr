<?php

use common\models\Applicant;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Applicant */
?>

Здравствуйте, <?= Html::encode($model->name) ?>!<br/>
<br/>
Большое спасибо за интерес, проявленный к нашей вакансии и потраченное время. К сожалению, по результатам полученной информации , в данный момент , мы не можем предложить Вам работу в нашем кинотеатре.<br/>
<br/>
В поиске работы Вам может помочь информационный портал Федеральной службы по труду и занятости России - http://www.trudvsem.ru/ , на данном ресурсе Вы можете получить информацию о общероссийском банке вакансий.<br/>
<br/>
Также мы всегда ждем вас в качестве нашего гостя в кинотеатре! Следите за нашей афишей кино и новостями на www.karofilm.ru<br/>
<br/>
Спасибо за заполненную заявку ,мы её сохраним в нашей базе данных, и, возможно, вернемся к Вашей кандидатуре, когда у нас возникнет такая потребность.<br/>
<br/>
С уважением,<br/>
Администрация кинотеатра <?= Html::encode(ArrayHelper::getValue($model, 'cinema.name')) ?><br/>