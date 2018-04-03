<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "skill".
 *
 * @property int $id
 * @property int $company_id
 * @property int $parent_skill_id
 * @property string $name
 * @property string $description
 *
 * @property EmployeeSkill[] $employeeSkills
 * @property Company $company
 * @property Skill $skill
 * @property Skill[] $skills
 */
class Skill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'name', 'description'], 'required'],
            [['company_id', 'parent_skill_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['parent_skill_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skill::class, 'targetAttribute' => ['parent_skill_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'parent_skill_id' => 'Parent Skill ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeSkills()
    {
        return $this->hasMany(EmployeeSkill::class, ['skill_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentSkill()
    {
        return $this->hasOne(Skill::class, ['id' => 'parent_skill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentSkills()
    {
        return $this->hasMany(Skill::class, ['parent_skill_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SkillQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SkillQuery(get_called_class());
    }
}
