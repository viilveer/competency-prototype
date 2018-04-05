<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[RoleSkill]].
 *
 * @see RoleSkill
 */
class RoleSkillQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RoleSkill[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RoleSkill|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
