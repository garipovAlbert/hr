<?php

namespace backend\controllers;

use backend\components\Controller;
use backend\helpers\ViewHelper;
use common\models\Cinema;
use common\models\City;
use common\models\search\VacancySearch;
use common\models\Vacancy;
use common\Rbac;
use kartik\grid\EditableColumnAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class VacancyController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::TASK_MANAGE_OBJECTS],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editable' => [
                'class' => EditableColumnAction::className(),
                'modelClass' => Vacancy::className(),
                'outputValue' => function (Vacancy $model, $attribute, $key, $index) {
                    if ($attribute === 'description') {
                        return nl2br($model->description);
                    }
                    if ($attribute === 'cinemaIdsString') {
                        $metros = Cinema::find()
                        ->where(['in', 'id', explode(',', $model->cinemaIdsString)])->all();
                        return ViewHelper::getMultipleLabel($metros);
                    }
                },
            ],
        ]);
    }

    public function actionIndex()
    {
        $model = new Vacancy;

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                return $this->ajaxValidate($model);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'New Vacancy created.'));
                return $this->refresh();
            }
        }

        $searchModel = new VacancySearch();
        $provider = $searchModel->search(Yii::$app->request->get());


        $cities = City::find()->active()
        ->with([
            'cinemas' => function($q) {
                $q->active()->orderBy(['name' => SORT_ASC]);
            },
        ])
        ->orderBy(['name' => SORT_ASC])
        ->all();

        return $this->render('index', [
            'model' => $model,
            'provider' => $provider,
            'searchModel' => $searchModel,
            'cities' => $cities,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return Vacancy
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Vacancy::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('app.error', 'The requested page does not exist.'));
        }

        return $model;
    }

}