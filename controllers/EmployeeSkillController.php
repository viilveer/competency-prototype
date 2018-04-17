<?php

namespace app\controllers;

use app\models\Employee;
use app\models\EmployeeSkill;
use app\models\Skill;
use competencyManagement\employee\EmployeeAnalyzer;
use competencyManagement\employee\EmployeeSkillAssigner;
use competencyManagement\skill\SkillTreeBuilder;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class EmployeeSkillController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * Displays homepage.
     *
     * @param int $employeeId
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionTree(int $employeeId)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $employee = Employee::findOne($employeeId);
        if ($employee === null) {
            throw new NotFoundHttpException('Employee not found');
        }

        $skills = Skill::find()->where(['company_id' => $employee->company_id])->all();
        $tree = (new SkillTreeBuilder($skills))->getTrees();
        $employeeSkillHelper = new EmployeeAnalyzer($employee, $skills);

        return (new EmployeeSkillAssigner($tree))
            ->assignSkillLevels($employeeSkillHelper->getAllSkills())
            ->getSkillTrees();
    }

    /**
     * Displays homepage.
     *
     * @param int $employeeId
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionJson(int $employeeId)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $employee = Employee::findOne($employeeId);
        if ($employee === null) {
            throw new NotFoundHttpException('Employee not found');
        }

        $grouped =  ArrayHelper::index(
            EmployeeSkill::find()->where(['employee_id' => $employeeId])->innerJoinWith('skill')->orderBy('skill_date')->all(),
            'id',
            'skill_id'
        );
        foreach ($grouped as $skillId => $items) {
            $grouped[$skillId] = array_values($items);
        }
        return $grouped;
    }

    /**
     * @param int|null $employeeId
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $employeeId)
    {
        $employee = Employee::findOne($employeeId);
        if ($employee === null) {
            throw new NotFoundHttpException('Employee not found');
        }
        $skills = Skill::find()->where(['company_id' => $employee->company_id])->all();
        $employeeSkillHelper = new EmployeeAnalyzer($employee, $skills);
        $employeeSkills = ArrayHelper::index(
            $employeeSkillHelper->getAssignedEmployeeSkills(),
            'skill_id'
        );

        return $this->render(
            'view',
            [
                'employee' => $employee,
                'employeeId' => $employeeId,
                'employeeSkills' => $employeeSkills,
                'skills' => $skills,
            ]
        );
    }

    /**
     * @param int $employeeId
     * @param int $skillId
     * @return bool|false|int
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdate(int $employeeId, int $skillId)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $params = ['employee_id' => $employeeId, 'skill_id' => $skillId, 'skill_date' => new Expression('CURDATE()')];
        $employeeSkill = EmployeeSkill::find()->where($params)->one();
        if ($employeeSkill === null) {
            $employeeSkill = new EmployeeSkill();
        }
        if (empty(\Yii::$app->request->post('skillLevel'))) {
            return $employeeSkill->delete();
        }

        $employeeSkill->setAttributes($params);
        $employeeSkill->level = \Yii::$app->request->post('skillLevel');
        return $employeeSkill->save();
    }
}
