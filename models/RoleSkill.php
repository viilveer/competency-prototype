<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_skill".
 *
 * @property int $id
 * @property int $role_id
 * @property int $competency_model_skill_id
 * @property double $level
 *
 * @property Role $role
 * @property CompetencyModelSkill $competencyModelSkill
 */
class RoleSkill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_skill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'competency_model_skill_id', 'level'], 'required'],
            [['role_id', 'competency_model_skill_id'], 'integer'],
            [['level'], 'number'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
            [['competency_model_skill_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompetencyModelSkill::className(), 'targetAttribute' => ['competency_model_skill_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'competency_model_skill_id' => 'Competency Model Skill ID',
            'level' => 'Level',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetencyModelSkill()
    {
        return $this->hasOne(CompetencyModelSkill::className(), ['id' => 'competency_model_skill_id']);
    }

    /**
     * For testing purposes only
     * @param CompetencyModelSkill $competencyModelSkill
     */
    public function setCompetencyModelSkill(CompetencyModelSkill $competencyModelSkill)
    {
        $this->competencyModelSkill = $competencyModelSkill;
    }

    /**
     * @inheritdoc
     * @return RoleSkillQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoleSkillQuery(get_called_class());
    }
}
