<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EmployeeSkill]].
 *
 * @see EmployeeSkill
 */
class EmployeeSkillQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return EmployeeSkill[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EmployeeSkill|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
