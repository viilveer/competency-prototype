<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_course".
 *
 * @property int $id
 * @property int $employee_id
 * @property int $course_id
 * @property string $status
 *
 * @property Employee $employee
 * @property Course $course
 * @property EmployeeCourseSkill[] $employeeCourseSkills
 */
class EmployeeCourse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'course_id', 'status'], 'required'],
            [['employee_id', 'course_id'], 'integer'],
            [['status'], 'string', 'max' => 32],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'course_id' => 'Course ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeCourseSkills()
    {
        return $this->hasMany(EmployeeCourseSkill::className(), ['employee_course_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return EmployeeCourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeCourseQuery(get_called_class());
    }
}
