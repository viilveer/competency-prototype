<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $company_id
 * @property int $competency_model_id
 *
 * @property EmployeeRole[] $employeeRoles
 * @property Company $company
 * @property CompetencyModel $competencyModel
 * @property RoleSkill[] $roleSkills
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'company_id'], 'required'],
            [['description'], 'string'],
            [['company_id', 'competency_model_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['competency_model_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompetencyModel::className(), 'targetAttribute' => ['competency_model_id' => 'id']],
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
            'description' => 'Description',
            'company_id' => 'Company ID',
            'competency_model_id' => 'Competency Model ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeRoles()
    {
        return $this->hasMany(EmployeeRole::className(), ['role_id' => 'id']);
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
    public function getCompetencyModel()
    {
        return $this->hasOne(CompetencyModel::className(), ['id' => 'competency_model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleSkills()
    {
        return $this->hasMany(RoleSkill::className(), ['role_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return RoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoleQuery(get_called_class());
    }

    /**
     * Needed for testing
     * @param RoleSkill[] $roleSkills
     */
    public function setRoleSkills(array $roleSkills)
    {
        $this->roleSkills = $roleSkills;
    }
}
