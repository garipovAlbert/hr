<?php

namespace backend\controllers;

use backend\components\Controller;
use backend\helpers\ViewHelper;
use common\models\City;
use common\models\search\CitySearch;
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
class CityController extends Controller
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
                'modelClass' => City::className(),
                'outputValue' => function (City $model, $attribute, $key, $index) {
                    if ($attribute === 'isActive') {
                        return ViewHelper::getBooleanIcon($model->isActive);
                    }
                },
            ]
        ]);
    }

    public function actionIndex()
    {
        $model = new City;

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                return $this->ajaxValidate($model);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'New City created.'));
                return $this->refresh();
            }
        }

        $searchModel = new CitySearch;
        $provider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'model' => $model,
            'provider' => $provider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return City
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = City::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('app.error', 'The requested page does not exist.'));
        }

        return $model;
    }

}