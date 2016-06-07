<?php

namespace frontend\controllers;

use common\components\AjaxActiveForm;
use common\models\Applicant;
use common\models\City;
use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new Applicant([
            'scenario' => Applicant::SCENARIO_FILL,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->render('index-success');
            }
        }

        return $this->render('index', [
            'model' => $model,
            'cities' => $this->getCityList(),
        ]);
    }

    public function actionLoadCinemas($cityId = null, $metroId = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return $this->renderAjax('index/cinemas', [
            'form' => new AjaxActiveForm(),
            'model' => new Applicant,
            'cityId' => $cityId,
            'metroId' => $metroId,
        ]);
    }

    public function actionLoadMetros($cityId)
    {
        return $this->renderAjax('index/metros', [
            'form' => new AjaxActiveForm(),
            'model' => new Applicant,
            'cityId' => $cityId,
        ]);
    }

    public function actionLoadVacancies($cinemaId)
    {
        return $this->renderAjax('index/vacancies', [
            'form' => new AjaxActiveForm(),
            'model' => new Applicant,
            'cinemaId' => $cinemaId,
        ]);
    }

    public function getCityList()
    {
        $models = City::find()
        ->joinWith(['cinemas.vacancies'])
        ->with(['metros'])
        ->andWhere('vacancy.id IS NOT NULL')
        ->all();

        return $models;
    }

    public function actionWeOffer()
    {
        return $this->render('we-offer');
    }
    
    public function actionJob()
    {
        return $this->render('job');
    }

}