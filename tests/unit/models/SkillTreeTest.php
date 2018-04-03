<?php

namespace tests\models;

use app\models\Skill;
use competencyManagement\skill\SkillTreeBuilder;

class SkillTreeTest extends \Codeception\Test\Unit
{
    public function testGeneration()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2', 'parent_skill_id' => 1])
        ];

        $tree = (new SkillTreeBuilder($skills))->getTree();
        expect($tree->getId())->equals($skills[0]->id);
        expect($tree->getChildren());
        expect($tree->getChildren()[0]->getId())->equals($skills[1]->id);
    }

    public function testGenerationWithTwoRootNodes()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2'])
        ];

        $this->expectException(\RuntimeException::class);
        (new SkillTreeBuilder($skills))->getTree();
    }

    public function testGenerationWithSingleItem()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
        ];

        $tree = (new SkillTreeBuilder($skills))->getTree();
        expect($tree->getId())->equals($skills[0]->id);
        expect_not($tree->getChildren());
    }
}
