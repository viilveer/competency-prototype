<?php

namespace app\controllers;

use app\models\EmployeeCourseSkill;
use yii\web\Controller;
use yii\web\Response;

class EmployeeCourseSkillController extends Controller
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
     * @param int $employeeCourseId
     * @param int $skillId
     * @return bool|false|int
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdate(int $employeeCourseId, int $skillId)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $params = ['employee_course_id' => $employeeCourseId, 'skill_id' => $skillId];
        $employeeSkill = EmployeeCourseSkill::find()->where($params)->one();
        if ($employeeSkill === null) {
            $employeeSkill = new EmployeeCourseSkill();
        }
        if (empty(\Yii::$app->request->post('skillLevel'))) {
            return $employeeSkill->delete();
        }

        $employeeSkill->setAttributes($params);
        $employeeSkill->modifier = \Yii::$app->request->post('skillLevel');
        return $employeeSkill->save();
    }
}
