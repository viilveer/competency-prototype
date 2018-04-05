<?php

namespace app\controllers;

use app\models\EmployeeRole;
use app\models\EmployeeRoleSearch;
use app\models\Skill;
use competencyManagement\employee\EmployeeAnalyzer;
use Yii;
use app\models\Employee;
use app\models\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        $model = $this->findModel($id);
        $employeeRoleSearchModel = new EmployeeRoleSearch();
        $employeeRoleDataProvider = $employeeRoleSearchModel->search(['user_id' => $id]);
        $companySkills = Skill::findAll(['company_id' => $model->company_id]);
        $employeeAnalyzer = new EmployeeAnalyzer($model, $companySkills);

        return $this->render('view', [
            'model' => $model,
            'employeeAnalyzer' => $employeeAnalyzer,
            'employeeRoleSearchModel' => $employeeRoleSearchModel,
            'employeeRoleDataProvider' => $employeeRoleDataProvider,
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $companyId
     * @return mixed
     */
    public function actionCreate(int $companyId)
    {
        $model = new Employee();
        $model->company_id = $companyId;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['company/view', 'id' => $model->company_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Employee model.
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
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $model = $this->findModel($id);

        $companyId = $model->company_id;
        EmployeeRole::deleteAll(['employee_id' => $id]);
        $model->delete();

        return $this->redirect(['company/view', 'id' => $companyId]);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
