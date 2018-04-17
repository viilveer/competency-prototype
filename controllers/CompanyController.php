<?php

namespace app\controllers;

use app\models\CompetencyModelSearch;
use app\models\CourseSearchForm;
use app\models\EmployeeSearch;
use app\models\RoleSearch;
use app\models\SkillSearchModel;
use competencyManagement\skill\SkillTreeBuilder;
use Yii;
use app\models\Company;
use app\models\CompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        $params = Yii::$app->request->getQueryParams();
        $employeeSearchModel = new EmployeeSearch();
        $employeeSearchModel->company_id = $id;
        $employeeDataProvider = $employeeSearchModel->search($params);

        $roleSearchModel = new RoleSearch();
        $roleSearchModel->company_id = $id;
        $roleDataProvider = $roleSearchModel->search($params);

        $courseSearchForm = new CourseSearchForm();
        $courseSearchForm->company_id = $id;
        $courseDataProvider = $courseSearchForm->search($params);

        $competencyModelSearchForm = new CompetencyModelSearch();
        $competencyModelSearchForm->company_id = $id;
        $competencyDataProvider = $competencyModelSearchForm->search($params);

        $skillSearchModel = new SkillSearchModel();
        $skillSearchModel->company_id = $id;
        $dataProvider = $skillSearchModel->search($params);

        $skillTrees = (new SkillTreeBuilder($dataProvider->getModels()))->getTrees();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'employeeDataProvider' => $employeeDataProvider,
            'employeeSearchModel' => $employeeSearchModel,
            'roleSearchModel' => $roleSearchModel,
            'roleDataProvider' => $roleDataProvider,
            'courseSearchForm' => $courseSearchForm,
            'courseDataProvider' => $courseDataProvider,
            'competencyModelSearchForm' => $competencyModelSearchForm,
            'competencyDataProvider' => $competencyDataProvider,
            'skillTrees' => $skillTrees,
        ]);
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Company model.
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
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
