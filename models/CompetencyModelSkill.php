<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "competency_model_skill".
 *
 * @property int $id
 * @property int $competency_model_id
 * @property int $skill_id
 * @property string $description
 *
 * @property CompetencyModel $competencyModel
 * @property Skill $skill
 */
class CompetencyModelSkill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'competency_model_skill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['competency_model_id', 'skill_id', 'description'], 'required'],
            [['competency_model_id', 'skill_id'], 'integer'],
            [['description'], 'string'],
            [['competency_model_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompetencyModel::className(), 'targetAttribute' => ['competency_model_id' => 'id']],
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
            'competency_model_id' => 'Competency Model ID',
            'skill_id' => 'Skill ID',
            'description' => 'Description',
        ];
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
    public function getSkill()
    {
        return $this->hasOne(Skill::className(), ['id' => 'skill_id']);
    }

    /**
     * @inheritdoc
     * @return CompetencyModelSkillQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetencyModelSkillQuery(get_called_class());
    }
}
