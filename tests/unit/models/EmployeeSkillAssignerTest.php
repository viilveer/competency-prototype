<?php

namespace tests\models;

use app\models\EmployeeSkill;
use app\models\Skill;
use competencyManagement\employee\EmployeeSkillAssigner;
use competencyManagement\skill\SkillTreeBuilder;

class EmployeeSkillAssignerTest extends \Codeception\Test\Unit
{
    public function testTreeWithAssignedSkills()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1])
        ];
        $tree = (new SkillTreeBuilder($skills))->getTree();
        $employeeSkills = [new EmployeeSkill(['skill_id' => 2, 'level' => 4])];

        $assigner = new EmployeeSkillAssigner($tree);
        $assigner->assignSkillLevels($employeeSkills);

        expect($assigner->getSkillTree()->getEmployeeSkillLevel())->isEmpty();
        expect($assigner->getSkillTree()->getChildren()[0]->getEmployeeSkillLevel())->equals(4);
    }
}
