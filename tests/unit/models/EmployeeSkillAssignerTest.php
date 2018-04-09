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
        $tree = (new SkillTreeBuilder($skills))->getTrees();
        $employeeSkills = [new EmployeeSkill(['skill_id' => 2, 'level' => 4])];

        $assigner = new EmployeeSkillAssigner($tree);
        $assigner->assignSkillLevels($employeeSkills);

        expect($assigner->getSkillTrees()[0]->getEmployeeSkillLevel())->isEmpty();
        expect($assigner->getSkillTrees()[0]->getChildren()[0]->getEmployeeSkillLevel())->equals(4);
    }

    public function testMultipleTreesWithAssignedSkills()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1]),
            new Skill(['id' => 3, 'name' => 'Test Skill 3']),
            new Skill(['id' => 4, 'name' => 'Test Skill 4']),
        ];
        $tree = (new SkillTreeBuilder($skills))->getTrees();
        $employeeSkills = [
            new EmployeeSkill(['skill_id' => 2, 'level' => 4]),
            new EmployeeSkill(['skill_id' => 4, 'level' => 4]),
        ];

        $assigner = new EmployeeSkillAssigner($tree);
        $assigner->assignSkillLevels($employeeSkills);

        expect($assigner->getSkillTrees()[0]->getEmployeeSkillLevel())->isEmpty();
        expect($assigner->getSkillTrees()[0]->getChildren()[0]->getEmployeeSkillLevel())->equals(4);
        expect($assigner->getSkillTrees()[1]->getEmployeeSkillLevel())->isEmpty();
        expect($assigner->getSkillTrees()[2]->getEmployeeSkillLevel())->equals(4);
    }
}
