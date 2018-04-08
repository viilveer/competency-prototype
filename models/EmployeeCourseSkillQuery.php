<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EmployeeCourseSkill]].
 *
 * @see EmployeeCourseSkill
 */
class EmployeeCourseSkillQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return EmployeeCourseSkill[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EmployeeCourseSkill|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
