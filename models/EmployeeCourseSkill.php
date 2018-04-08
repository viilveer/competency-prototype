<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_course_skill".
 *
 * @property int $id
 * @property int $employee_course_id
 * @property int $skill_id
 * @property float $modifier
 *
 * @property EmployeeCourse $employeeCourse
 * @property Skill $skill
 */
class EmployeeCourseSkill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_course_skill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_course_id', 'skill_id', 'modifier'], 'required'],
            [['employee_course_id', 'skill_id'], 'integer'],
            [['modifier'], 'number'],
            [['employee_course_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeCourse::className(), 'targetAttribute' => ['employee_course_id' => 'id']],
            [['skill_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skill::className(), 'targetAttribute' => ['skill_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_course_id' => 'Employee Course ID',
            'skill_id' => 'Skill ID',
            'modifier' => 'Modifier',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeCourse()
    {
        return $this->hasOne(EmployeeCourse::className(), ['id' => 'employee_course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(Skill::className(), ['id' => 'skill_id']);
    }

    /**
     * @inheritdoc
     * @return EmployeeCourseSkillQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeCourseSkillQuery(get_called_class());
    }
}
