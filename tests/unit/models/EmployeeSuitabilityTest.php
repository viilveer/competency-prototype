<?php

namespace tests\models;

use app\models\Employee;
use app\models\EmployeeSkill;
use app\models\Role;
use app\models\RoleSkill;
use app\models\Skill;
use competencyManagement\employee\EmployeeAnalyzer;

class EmployeeSuitabilityTest extends \Codeception\Test\Unit
{
    public function testSuitabilityCalculation()
    {
        $employee = new Employee([
            'name' => 'Test Employee',
            'employeeSkills' => [
                new EmployeeSkill(['skill_id' => 2, 'level' => 1])
            ],
        ]);

        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1])
        ];

        $role = new Role([
            'name' => 'Test role',
            'roleSkills' => [
                new RoleSkill(['skill_id' => 2, 'level' => 4])
            ],
        ]);

        $employeeAnalyzer = new EmployeeAnalyzer($employee, $skills);
        expect($employeeAnalyzer->getEmployeeCompetency($role))->notEmpty();
        expect($employeeAnalyzer->getEmployeeCompetency($role))->equals(0.25);
    }

    public function testSuitabilityCalculationWithoutEmployeeSkill()
    {
        $employee = new Employee([
            'name' => 'Test Employee',
        ]);

        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1])
        ];

        $role = new Role([
            'name' => 'Test role',
            'roleSkills' => [
                new RoleSkill(['skill_id' => 2, 'level' => 4])
            ],
        ]);
        $employeeAnalyzer = new EmployeeAnalyzer($employee, $skills);
        expect($employeeAnalyzer->getEmployeeCompetency($role))->equals(0);
    }

    public function testSuitabilityCalculationWithCalculatedSkill()
    {
        $employee = new Employee([
            'name' => 'Test Employee',
            'employeeSkills' => [
                new EmployeeSkill(['skill_id' => 1, 'level' => 1])
            ],
        ]);

        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1])
        ];

        $role = new Role([
            'name' => 'Test role',
            'roleSkills' => [
                new RoleSkill(['skill_id' => 2, 'level' => 0.25])
            ],
        ]);
        $employeeAnalyzer = new EmployeeAnalyzer($employee, $skills);
        expect($employeeAnalyzer->getEmployeeCompetency($role))->equals(1);
    }
}
