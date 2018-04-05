<?php


namespace competencyManagement\employee;


use app\models\Employee;
use app\models\EmployeeSkill;
use app\models\Role;
use app\models\Skill;
use competencyManagement\competency\EmployeeCompetencyCalculator;
use yii\helpers\ArrayHelper;

class EmployeeAnalyzer
{
    /**
     * @var Employee
     */
    private $employee;
    /**
     * @var Skill
     */
    private $companySkills;


    public function __construct(Employee $employee, array $companySkills = [])
    {
        $this->employee = $employee;
        $this->companySkills = $companySkills;
    }

    /**
     * Returns employee all skills (including calculated skills)
     * @return EmployeeSkill[]
     */
    public function getAllSkills(): array
    {
        return ArrayHelper::merge($this->employee->employeeSkills, $this->getCalculatedSkills());
    }

    /**
     * Returns employee calculated skills
     * @return EmployeeSkill[]
     */
    public function getCalculatedSkills(): array
    {
        $calculator = new EmployeeSkillCalculator($this->companySkills, $this->employee->employeeSkills);
        return $calculator->getEmployeeCalculatedSkills();
    }

    /**
     * Returns HR assigned skills
     * @return EmployeeSkill[]
     */
    public function getAssignedEmployeeSkills(): array
    {
        return $this->employee->employeeSkills;
    }

    /**
     * @param Role $role
     * @return float
     */
    public function getEmployeeCompetency(Role $role)
    {
        $calculator = new EmployeeCompetencyCalculator($role->roleSkills, $this->getAllSkills());
        return $calculator->calculate();
    }
}