<?php

namespace app\controllers;

use app\models\EmployeeSkill;
use app\models\Skill;
use competencyManagement\skill\EmployeeSkillAssigner;
use competencyManagement\skill\EmployeeSkillCalculator;
use competencyManagement\skill\SkillTreeBuilder;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\View;

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
     * @param null $employeeId
     * @return string
     */
    public function actionTree($employeeId = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $skills = Skill::find()->all();
        $tree = (new SkillTreeBuilder($skills))->getTree();
        $employeeSkills = EmployeeSkill::find()->where(['employee_id' => $employeeId])->all();

        $calculator = new EmployeeSkillCalculator($skills, $employeeSkills);

        return (new EmployeeSkillAssigner($tree))
            ->assignSkillLevels(ArrayHelper::merge($employeeSkills, $calculator->getEmployeeCalculatedSkills()))
            ->getSkillTree();
    }

    /**
     * @param null $employeeId
     * @return string
     */
    public function actionSkills($employeeId = null)
    {
        $this->getView()->registerJsFile(
            'https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.js',
            ['position' => View::POS_HEAD]
        );
        return $this->render('skills', ['employeeId' => $employeeId]);
    }
}
