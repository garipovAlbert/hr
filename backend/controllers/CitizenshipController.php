<?php

namespace backend\controllers;

use backend\components\Controller;
use common\models\Citizenship;
use common\models\search\CitizenshipSearch;
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
class CitizenshipController extends Controller
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
                'modelClass' => Citizenship::className(),
            ]
        ]);
    }

    public function actionIndex()
    {
        $model = new Citizenship;

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                return $this->ajaxValidate($model);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'New Citizenship created.'));
                return $this->refresh();
            }
        }

        $searchModel = new CitizenshipSearch;
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
     * @return Citizenship
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Citizenship::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('app.error', 'The requested page does not exist.'));
        }

        return $model;
    }

}