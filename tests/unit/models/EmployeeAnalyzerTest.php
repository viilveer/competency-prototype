<?php

namespace tests\models;

use app\models\Employee;
use app\models\EmployeeSkill;
use app\models\Skill;
use competencyManagement\employee\EmployeeAnalyzer;

class EmployeeAnalyzerTest extends \Codeception\Test\Unit
{
    public function testEmployeeAnalyzerSkillGetters()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1])
        ];

        $employee = new Employee([
            'name' => 'Test Employee',
            'employeeSkills' => [
                new EmployeeSkill(['skill_id' => 2, 'level' => 1])
            ],
        ]);

        $employeeAnalyzer = new EmployeeAnalyzer($employee, $skills);

        expect($employeeAnalyzer->getAssignedEmployeeSkills()[0]->level)->equals(1);
        expect($employeeAnalyzer->getCalculatedSkills()[0]->level)->equals(0.5);
        expect($employeeAnalyzer->getCalculatedSkills()[0]->skill_id)->equals(1);
        expect($employeeAnalyzer->getAllSkills()[0]->skill_id)->equals(2);
        expect($employeeAnalyzer->getAllSkills()[1]->skill_id)->equals(1);
    }

    public function testEmployeeAnalyzerSkillGettersWithoutEmployeeSkills()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1])
        ];

        $employee = new Employee([
            'name' => 'Test Employee',
        ]);

        $employeeAnalyzer = new EmployeeAnalyzer($employee, $skills);

        expect($employeeAnalyzer->getAssignedEmployeeSkills())->isEmpty();
    }

}
