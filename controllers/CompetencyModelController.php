<?php

namespace app\controllers;

use app\models\CompetencyModelSkillSearch;
use Yii;
use app\models\CompetencyModel;
use app\models\CompetencyModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompetencyModelController implements the CRUD actions for CompetencyModel model.
 */
class CompetencyModelController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CompetencyModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompetencyModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompetencyModel model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $competencyModelSkillSearch = new CompetencyModelSkillSearch();
        $competencyModelSkillSearch->competency_model_id = $id;
        $competencyModelDataProvider = $competencyModelSkillSearch->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'competencyModelSkillSearch' => $competencyModelSkillSearch,
            'competencyModelDataProvider' => $competencyModelDataProvider
        ]);
    }

    /**
     * Creates a new CompetencyModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $companyId
     * @return mixed
     */
    public function actionCreate(int $companyId)
    {
        $model = new CompetencyModel();
        $model->company_id = $companyId;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CompetencyModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CompetencyModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CompetencyModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompetencyModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompetencyModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
