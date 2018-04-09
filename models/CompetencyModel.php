<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "competency_model".
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $type
 *
 * @property Company $company
 * @property CompetencyModelSkill[] $competencyModelSkills
 */
class CompetencyModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'competency_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'name', 'type'], 'required'],
            [['company_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 64],
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
            'company_id' => 'Company ID',
            'name' => 'Name',
            'type' => 'Type',
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
    public function getCompetencyModelSkills()
    {
        return $this->hasMany(CompetencyModelSkill::className(), ['competency_model_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CompetencyModelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetencyModelQuery(get_called_class());
    }
}
