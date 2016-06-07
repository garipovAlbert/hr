<?php

namespace backend\controllers;

use backend\components\Controller;
use backend\helpers\ViewHelper;
use common\models\Cinema;
use common\models\Metro;
use common\models\search\CinemaSearch;
use common\Rbac;
use kartik\grid\EditableColumnAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class CinemaController extends Controller
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
                'modelClass' => Cinema::className(),
                'outputValue' => function (Cinema $model, $attribute, $key, $index) {
                    if ($attribute === 'cityId') {
                        return ArrayHelper::getValue($model, 'city.name');
                    }
                    if ($attribute === 'metroIdsString') {
                        $metros = Metro::find()
                        ->andWhere(['in', 'id', explode(',', $model->metroIdsString)])->all();
                        return ViewHelper::getMultipleLabel($metros);
                    }
                    if ($attribute === 'isActive') {
                        return ViewHelper::getBooleanIcon($model->isActive);
                    }
                },
            ]
        ]);
    }

    public function actionIndex()
    {
        $model = new Cinema;

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                return $this->ajaxValidate($model);
            }

            if ($model->save()) {
                // flash
                Yii::$app->session->setFlash('success', Yii::t('app', 'New Cinema created.'));

                return $this->refresh();
            }
        }

        $searchModel = new CinemaSearch;
        $provider = $searchModel->search(Yii::$app->request->get());


        return $this->render('index', [
            'provider' => $provider,
            'searchModel' => $searchModel,
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return Cinema
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Cinema::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('app.error', 'The requested page does not exist.'));
        }

        return $model;
    }

}