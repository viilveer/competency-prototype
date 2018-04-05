<?php

namespace app\models;


/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $name
 * @property int $age
 * @property string $gender
 * @property int $company_id
 *
 * @property Company $company
 * @property EmployeeRole[] $employeeRoles
 * @property EmployeeSkill[] $employeeSkills
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'age', 'gender', 'company_id'], 'required'],
            [['age', 'company_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['gender'], 'string', 'max' => 32],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'age' => 'Age',
            'gender' => 'Gender',
            'company_id' => 'Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeRoles()
    {
        return $this->hasMany(EmployeeRole::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeSkills()
    {
        return $this->hasMany(EmployeeSkill::className(), ['employee_id' => 'id']);
    }

    /**
     * Needed for testing
     * @param EmployeeSkill[] $employeeSkills
     */
    public function setEmployeeSkills(array $employeeSkills)
    {
        $this->employeeSkills = $employeeSkills;
    }

    /**
     * @inheritdoc
     * @return EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeQuery(get_called_class());
    }
}
