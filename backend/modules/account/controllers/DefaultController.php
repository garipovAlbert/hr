<?php

namespace backend\modules\account\controllers;

use backend\components\Controller;
use common\models\Account;
use common\models\search\AccountSearch;
use common\Rbac;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `account` module
 * @author Albert Garipov <bert320@gmail.com>
 */
class DefaultController extends Controller
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
                        'roles' => [Rbac::TASK_MANAGE_ACCOUNT],
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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AccountSearch([
            'query' => Account::find()->andWhere(['!=', 'role', Account::ROLE_ADMIN]),
        ]);

        $provider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'provider' => $provider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new Account;

        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                return $this->ajaxValidate($model);
            }


            if ($model->save()) {
                // flash
                $msg = Yii::t('app', 'New account added.') . ' '
                . Html::a(Yii::t('app', 'Add another...'), ['create']);
                Yii::$app->getSession()->setFlash('success', $msg);

                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                return $this->ajaxValidate($model);
            }
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Data saved.'));
                return $this->refresh();
            }
        }

        return $this->render('update', [
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
     * @return Account
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Account::find()
        ->andWhere(['!=', 'role', Account::ROLE_ADMIN])
        ->andWhere(['id' => $id])
        ->one();

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }

}