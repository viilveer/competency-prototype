<?php

namespace app\models;


/**
 * This is the model class for table "role_skill".
 *
 * @property int $id
 * @property int $role_id
 * @property int $skill_id
 * @property double $level
 *
 * @property Role $role
 * @property Skill $skill
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
            [['role_id', 'skill_id', 'level'], 'required'],
            [['role_id', 'skill_id'], 'integer'],
            [['level'], 'number'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
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
            'role_id' => 'Role ID',
            'skill_id' => 'Skill ID',
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
    public function getSkill()
    {
        return $this->hasOne(Skill::className(), ['id' => 'skill_id']);
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
