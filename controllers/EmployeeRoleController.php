<?php

namespace app\controllers;

use app\models\Employee;
use app\models\Role;
use app\models\RoleSearch;
use Yii;
use app\models\EmployeeRole;
use app\models\EmployeeRoleSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeRoleController implements the CRUD actions for EmployeeRole model.
 */
class EmployeeRoleController extends Controller
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
     * Lists all EmployeeRole models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeRoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployeeRole model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EmployeeRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $employeeId
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate(int $employeeId)
    {
        $employee = Employee::findOne($employeeId);
        if (!$employee) {
            throw new NotFoundHttpException('Employee not found');
        }
        $model = new EmployeeRole();
        $model->employee_id = $employeeId;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['employee/view', 'id' => $employeeId]);
        }

        $companyRoles = (new RoleSearch())->search(['company_id' => $employee->company_id])->getModels();

        return $this->render('create', [
            'model' => $model,
            'companyRoles' => ArrayHelper::map($companyRoles, 'id', 'name'),
        ]);
    }

    /**
     * Updates an existing EmployeeRole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
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
     * Deletes an existing EmployeeRole model.
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

        $employeeId = $model->employee_id;
        $model->delete();

        return $this->redirect(['employee/view', 'id' => $employeeId]);
    }

    /**
     * @param int $id
     * @param int $employeeId
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionToggleRole(int $id, int $employeeId)
    {
        $params = ['role_id' => $id, 'employee_id' => $employeeId];
        $model = EmployeeRole::find()->where($params)->one();
        if (is_null($model)) {
            $model = new EmployeeRole($params);
            $model->save();
        } else {
            $model->delete();
        }
        $this->redirect(Yii::$app->request->getReferrer());
    }

    /**
     * Finds the EmployeeRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployeeRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmployeeRole::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
