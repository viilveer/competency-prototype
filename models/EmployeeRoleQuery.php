<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EmployeeRole]].
 *
 * @see EmployeeRole
 */
class EmployeeRoleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return EmployeeRole[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EmployeeRole|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
