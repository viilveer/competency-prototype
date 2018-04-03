<?php

namespace tests\models;

use app\models\EmployeeSkill;
use app\models\Skill;
use competencyManagement\skill\EmployeeSkillCalculator;

class EmployeeSkillCalculationTest extends \Codeception\Test\Unit
{
    public function testSkillCalculationWithoutAnyEmployeeSkill()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1])
        ];

        $employeeSkills = [];
        $calculator = new EmployeeSkillCalculator($skills, $employeeSkills);
        expect($calculator->getEmployeeCalculatedSkills())->isEmpty();
    }

    public function testSkillCalculation()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1])
        ];

        $employeeSkills = [new EmployeeSkill(['skill_id' => 2, 'level' => 4])];
        $calculator = new EmployeeSkillCalculator($skills, $employeeSkills);
        expect($calculator->getEmployeeCalculatedSkills())->count(1);
        expect($calculator->getEmployeeCalculatedSkills()[0]->level)->equals(2);
    }

    public function testSkillCalculationWhenNothingToCalculate()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1])
        ];

        $employeeSkills = [new EmployeeSkill(['skill_id' => 2, 'level' => 4]), new EmployeeSkill(['skill_id' => 1, 'level' => 4])];
        $calculator = new EmployeeSkillCalculator($skills, $employeeSkills);
        expect($calculator->getEmployeeCalculatedSkills())->count(0);
    }
}
