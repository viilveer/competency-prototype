<?php

namespace competencyManagement\competency;

use app\models\EmployeeSkill;
use app\models\RoleSkill;
use yii\helpers\ArrayHelper;

class EmployeeCompetencyCalculator
{
    /**
     * @var RoleSkill[] array
     */
    private $roleSkills;
    /**
     * @var EmployeeSkill[] array
     */
    private $employeeSkills;

    /**
     * EmployeeCompetencyCalculator constructor.
     * @param RoleSkill[] $roleSkills
     * @param EmployeeSkill[] $employeeSkills
     */
    public function __construct(array $roleSkills, array $employeeSkills)
    {
        $this->roleSkills = ArrayHelper::index($roleSkills, function (RoleSkill $skill) {
            return $skill->competencyModelSkill->skill_id;
        });
        $this->employeeSkills = ArrayHelper::index($employeeSkills, 'skill_id');
    }

    /**
     * @return float
     */
    public function calculate()
    {
        $roleSkillCount = count($this->roleSkills);
        $totalSuitability = 0;
        foreach ($this->roleSkills as $skillId => $roleSkill) {
            /** @var EmployeeSkill $employeeSkill */
            $employeeSkill = ArrayHelper::getValue($this->employeeSkills, $skillId);
            $employeeSkillLevel = $employeeSkill ? $employeeSkill->level : 0;
            $totalSuitability += $employeeSkillLevel / $roleSkill->level;
        }
        return $totalSuitability / $roleSkillCount;
    }
}
