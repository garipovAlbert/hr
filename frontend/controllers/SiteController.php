<?php

namespace frontend\controllers;

use common\components\AjaxActiveForm;
use common\models\Applicant;
use common\models\City;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
        if (!$this->checkApplicantTimeout()) {
            return $this->render('index-success');
        }

        $model = new Applicant([
            'scenario' => Applicant::SCENARIO_FILL,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->sms->send('+7' . $model->phone, Yii::t('app', 'Your code is: {code}', [
                    'code' => $model->confirmationCode,
                ]));

                return $this->redirect(['confirm', 'id' => $model->id]);
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

    public function actionConfirm($id)
    {
        if (!$this->checkApplicantTimeout()) {
            return $this->render('index-success');
        }

        $model = $this->findModel($id);
        $model->scenario = Applicant::SCENARIO_CONFIRM;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->status = Applicant::STATUS_NEW;
                $model->save(false);

                $this->view->params['googleEvent'] = [
                    'hitType' => 'event',
                    'eventCategory' => 'KaroHR_applicant',
                    'eventAction' => Yii::t('app', 'New Application added'),
                    'eventLabel' => $model->name,
                ];
                return $this->render('index-success');
            }
        }

        return $this->render('confirm', [
            'model' => $model,
        ]);
    }

    /**
     * Not more than 3 attempts per hour allowed.
     * @return boolean
     */
    private function checkApplicantTimeout()
    {
        $count = Applicant::find()
        ->andWhere([
            'ip' => Yii::$app->request->getUserIP(),
            'status' => Applicant::STATUS_UNCONFIRMED,
        ])
        ->andWhere(['>', 'createdAt', time() - 60 * 60]) // 1 hour timeout
        ->count();

        return $count < 3;
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

    /**
     * @param int $id
     * @return Applicant
     */
    public function findModel($id)
    {
        $model = Applicant::find()
        ->andWhere([
            'id' => $id,
            'ip' => Yii::$app->request->getUserIP(),
            'status' => Applicant::STATUS_UNCONFIRMED,
        ])
        ->andWhere(['>', 'createdAt', time() - 40 * 60]) // 20 minutes timeout
        ->one();

        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('app.error', 'The requested page does not exist.'));
        }

        return $model;
    }

}