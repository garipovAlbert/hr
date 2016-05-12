<?php

namespace backend\controllers;

use backend\components\Controller;
use common\models\Metro;
use common\models\search\MetroSearch;
use kartik\grid\EditableColumnAction;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class MetroController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editable' => [
                'class' => EditableColumnAction::className(),
                'modelClass' => Metro::className(),
                'outputValue' => function (Metro $model, $attribute, $key, $index) {
                    if ($attribute === 'cityId') {
                        return ArrayHelper::getValue($model, 'city.name');
                    }
                },
            ]
        ]);
    }

    public function actionIndex()
    {
        $model = new Metro;

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                return $this->ajaxValidate($model);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'New Metro Station created.'));
                return $this->refresh();
            }
        }

        $searchModel = new MetroSearch;
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
     * @return Metro
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Metro::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('app.error', 'The requested page does not exist.'));
        }

        return $model;
    }

}