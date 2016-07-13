<?php

namespace backend\controllers;

use backend\components\Controller;
use backend\components\CustomExcel;
use common\models\Applicant;
use common\models\search\ApplicantSearch;
use common\Rbac;
use kartik\grid\EditableColumnAction;
use Yii;
use yii\base\Action;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class ApplicantController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'decline' => ['post'],
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
                'modelClass' => Applicant::className(),
                'findModel' => function ($id, Action $action) {
                    $model = $action->controller->findModel($id);
                    $model->scenario = Applicant::SCENARIO_PROCESS;
                    return $model;
                },
                'outputValue' => function (Applicant $model, $attribute, $key, $index) {
                    if ($attribute === 'status') {
                        return ArrayHelper::getValue(Applicant::statusList(), $model->status);
                    }
                },
            ]
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new ApplicantSearch;
        $provider = $searchModel->search(Yii::$app->request->get());

        $selected = [];
        if (Yii::$app->request->post('selection')) {
            $ids = Yii::$app->request->post('selection');
            $selected = Applicant::find()->andWhere(['in', 'id', $ids])->all();
        }

        if (Yii::$app->request->post('decline')) {
            foreach ($selected as $model) {
                $model->decline();
            }
        }
        if (Yii::$app->request->post('delete') && Yii::$app->user->can(Rbac::TASK_DELETE_APPLICANT)) {
            foreach ($selected as $model) {
                $model->delete();
            }
        }
        if (Yii::$app->request->post('export')) {
            $ids = Yii::$app->request->post('selection', []);
            return $this->export($ids);
        }

        return $this->render('index', [
            'provider' => $provider,
            'searchModel' => $searchModel,
        ]);
    }

    private function export($ids)
    {
        $statusList = Applicant::statusList();

        $query = Applicant::find()
        ->with([
            'cinema.city',
            'citizenship',
            'vacancy',
        ]);

        $query->andWhere(['!=', 'status', Applicant::STATUS_UNCONFIRMED]);

        if (count($ids)) {
            $query->andWhere(['in', 'id', $ids]);
        }

        $helperModel = new Applicant;

        CustomExcel::export([
            'models' => $query->asArray()->all(),
            'columns' => [
                [
                    'header' => 'ID',
                    'attribute' => 'id',
                ],
                [
                    'header' => Yii::t('app', 'Date'),
                    'attribute' => 'createdAt:date',
                ],
                [
                    'header' => Yii::t('app', 'City'),
//                    'attribute' => 'cinema.city.name',
                    'options' => [
                        'style' => 'width: 300px',
                    ],
                    'value' => function($model) {
                        if (isset($model['cinema']['city']['name'])) {
                            return $model['cinema']['city']['name'];
                        }
                    }
                ],
                [
                    'header' => Yii::t('app', 'Cinema'),
                    'value' => function($model) {
                        if (isset($model['cinema']['name'])) {
                            return $model['cinema']['name'];
                        }
                    }
                ],
                [
                    'header' => Yii::t('app', 'Applicant Name'),
                    'attribute' => 'name',
                ],
                [
                    'header' => Yii::t('app', 'Age'),
                    'attribute' => 'age',
                ],
                [
                    'header' => Yii::t('app', 'Citizenship'),
                    'value' => function($model) {
                        if (isset($model['citizenship']['name'])) {
                            return $model['citizenship']['name'];
                        }
                    }
                ],
                [
                    'header' => Yii::t('app', 'Phone'),
                    'value' => function($model) {
                        if ($model['phone']) {
                            return '+7 (' . substr($model['phone'], 0, 3) . ') '
                            . substr($model['phone'], 3, 3)
                            . '-' . substr($model['phone'], 6, 2)
                            . '-' . substr($model['phone'], 8);
                        }
                    },
                ],
                [
                    'header' => 'E-mail',
                    'attribute' => 'email',
                ],
                [
                    'header' => Yii::t('app', 'Vacancy'),
                    'value' => function($model) {
                        if (isset($model['vacancy']['name'])) {
                            return $model['vacancy']['name'];
                        }
                    }
                ],
                [
                    'header' => Yii::t('app', 'Status'),
                    'value' => function($model) use ($statusList) {
                        return ArrayHelper::getValue($statusList, $model['status']);
                    },
                ],
            ],
            'format' => 'Excel2007',
            'fileName' => 'applicants.xlsx',
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionUpdateAjax($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);
        $model->scenario = Applicant::SCENARIO_PROCESS;

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
        }

        return [
            'output' => ArrayHelper::getValue(Applicant::statusList(), $model->status),
            'message' => '',
        ];
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