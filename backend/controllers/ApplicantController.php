<?php

namespace backend\controllers;

use backend\components\Controller;
use common\models\Applicant;
use common\models\search\ApplicantSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class ApplicantController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new ApplicantSearch;
        $provider = $searchModel->search(Yii::$app->request->get());


        return $this->render('index', [
            'provider' => $provider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDecline($id)
    {
        $this->findModel($id)->decline();

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return Applicant
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Applicant::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('app.error', 'The requested page does not exist.'));
        }

        return $model;
    }

}