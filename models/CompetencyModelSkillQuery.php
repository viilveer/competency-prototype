<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CompetencyModelSkill]].
 *
 * @see CompetencyModelSkill
 */
class CompetencyModelSkillQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CompetencyModelSkill[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CompetencyModelSkill|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
