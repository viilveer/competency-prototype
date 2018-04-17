<?php

namespace tests\models;

use app\models\Employee;
use app\models\EmployeeCourseSkill;
use app\models\EmployeeSkill;
use competencyManagement\employee\EmployeeSkillImprover;

class EmployeeSkillImproverTest extends \Codeception\Test\Unit
{
    public function testImprovingSkillWithExistingEmployeeSkill()
    {
        $employeeCourseSkill = [
            new EmployeeCourseSkill(['skill_id' => 1, 'modifier' => 1]),
        ];

        $employee = new Employee([
            'name' => 'Test Employee',
        ]);

        $improver = new EmployeeSkillImprover($employee);
        $improvedSkills = $improver->improveSkills($employeeCourseSkill);

        expect($improvedSkills)->notEmpty();
        expect($improvedSkills[0]->level)->equals(1);
    }

    public function testImprovingSkillWithEmptySet()
    {
        $employeeCourseSkill = [];

        $employee = new Employee([
            'name' => 'Test Employee',
        ]);

        $improver = new EmployeeSkillImprover($employee);
        $improvedSkills = $improver->improveSkills($employeeCourseSkill);

        expect($improvedSkills)->isEmpty();
    }

    public function testImprovingSkillWithoutExistingEmployeeSkill()
    {
        $employee = new Employee([
            'name' => 'Test Employee',
            'employeeSkills' => [
                new EmployeeSkill(['skill_id' => 2, 'level' => 1]),
                new EmployeeSkill(['skill_id' => 3, 'level' => 1])
            ],
        ]);

        $employeeCourseSkill = [
            new EmployeeCourseSkill(['skill_id' => 1, 'modifier' => 0.5]),
            new EmployeeCourseSkill(['skill_id' => 2, 'modifier' => 1]),
            new EmployeeCourseSkill(['skill_id' => 3, 'modifier' => 10]),
        ];

        $improver = new EmployeeSkillImprover($employee);
        $improvedSkills = $improver->improveSkills($employeeCourseSkill);

        expect($improvedSkills)->notEmpty();
        expect($improvedSkills[0]->level)->equals(0.5);
        expect($improvedSkills[1]->level)->equals(1);
        expect($improvedSkills[2]->level)->equals(10);
    }
}
