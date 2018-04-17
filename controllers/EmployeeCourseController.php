<?php

namespace app\controllers;

use app\models\Course;
use app\models\EmployeeCourseSkill;
use app\models\Skill;
use competencyManagement\employee\EmployeeSkillImprover;
use Yii;
use app\models\EmployeeCourse;
use app\models\EmployeeCourseSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeCourseController implements the CRUD actions for EmployeeCourse model.
 */
class EmployeeCourseController extends Controller
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
     * Lists all EmployeeCourse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeCourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployeeCourse model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $skills = Skill::findAll(['company_id' => $model->course->company_id]);
        $employeeCourseSkills = ArrayHelper::index(
            EmployeeCourseSkill::findAll(['employee_course_id' => $id]),
            'skill_id'
        );
        $employeeSkills = ArrayHelper::index($model->employee->employeeSkills, 'skill_id');
        return $this->render('view', [
            'model' => $model,
            'skills' => $skills,
            'employeeCourseSkills' => $employeeCourseSkills,
            'employeeSkills' => $employeeSkills,
        ]);
    }

    /**
     * Creates a new EmployeeCourse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $courseId
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($courseId)
    {
        $course = Course::findOne($courseId);
        if (!$course) {
            throw new NotFoundHttpException('Course not found');
        }
        $model = new EmployeeCourse();
        $model->course_id = $courseId;
        $model->status = 'STARTED';


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['course/view', 'id' => $model->course_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'course' => $course,
        ]);
    }

    /**
     * Deletes an existing EmployeeCourse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        return $this->redirect(['course/view', 'id' => $model->course_id]);
    }

    /**
     * Finds the EmployeeCourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployeeCourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmployeeCourse::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $id
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionMarkAsCompleted(int $id)
    {
        $model = EmployeeCourse::find()
            ->innerJoinWith(['employeeCourseSkills', 'employee', 'employee.employeeSkills'])
            ->where([EmployeeCourse::tableName() . '.id' => $id, 'status' => 'STARTED'])
            ->one();
        $improver = new EmployeeSkillImprover($model->employee);
        $improvedSkills = $improver->improveSkills($model->employeeCourseSkills);
        $model->status = 'FINISHED';
        Yii::$app->db->transaction(function () use ($model, $improvedSkills) {
            $model->save();
            foreach ($improvedSkills as $improvedSkill) {
                $improvedSkill->save();
            }
        });

        $this->redirect(Yii::$app->request->referrer);
    }
}
