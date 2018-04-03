<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_skill".
 *
 * @property int $id
 * @property int $employee_id
 * @property int $skill_id
 * @property int $level
 *
 * @property Employee $employee
 * @property Skill $skill
 */
class EmployeeSkill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_skill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'skill_id', 'level'], 'required'],
            [['employee_id', 'skill_id', 'level'], 'integer'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
            [['skill_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skill::class, 'targetAttribute' => ['skill_id' => 'id']],
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
            'skill_id' => 'Skill ID',
            'level' => 'Level',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(Skill::class, ['id' => 'skill_id']);
    }

    /**
     * @inheritdoc
     * @return EmployeeSkillQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeSkillQuery(get_called_class());
    }
}
