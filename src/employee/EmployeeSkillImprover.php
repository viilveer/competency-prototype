<?php

namespace competencyManagement\employee;

use app\models\Employee;
use app\models\EmployeeCourseSkill;
use app\models\EmployeeSkill;
use yii\helpers\ArrayHelper;

/**
 * Main functionality is for improving employee skills by information from course skills
 * @package competencyManagement\employee
 */
class EmployeeSkillImprover
{
    /**
     * @var Employee
     */
    private $employee;

    /**
     * EmployeeSkillImprover constructor.
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Improves all skills which are needed by courseSkills
     * @param EmployeeCourseSkill[] $courseSkills
     * @return EmployeeSkill[]
     */
    public function improveSkills(array $courseSkills): array
    {
        $employeeSkills = ArrayHelper::index($this->employee->employeeSkills, 'skill_id');
        $improvedSkills = [];

        foreach ($courseSkills as $courseSkill) {
            /** @var EmployeeSkill $employeeSkill */
            $employeeSkill = ArrayHelper::getValue($employeeSkills, $courseSkill->skill_id, new EmployeeSkill());
            $improvedSkills[] = $this->improveSkill($employeeSkill, $courseSkill);
        }
        return $improvedSkills;
    }

    /**
     * Improves single skill
     * Uses linear graph formula to improve skill when employee skill level is greater than max_gain_until
     * @param EmployeeSkill $employeeSkill
     * @param EmployeeCourseSkill $courseSkill
     * @return EmployeeSkill
     */
    private function improveSkill(EmployeeSkill $employeeSkill, EmployeeCourseSkill $courseSkill)
    {
        $employeeSkill->employee_id = $this->employee->id;
        $employeeSkill->skill_id = $courseSkill->skill_id;
        $employeeSkill->level += $courseSkill->modifier;
        return $employeeSkill;
    }
}
