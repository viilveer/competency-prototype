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

        $trees = (new SkillTreeBuilder($skills))->getTrees();
        expect($trees[0]->getId())->equals($skills[0]->id);
        expect($trees[0]->getChildren());
        expect($trees[0]->getChildren()[0]->getId())->equals($skills[1]->id);
    }

    public function testGenerationWithTwoRootNodes()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
            new Skill(['id' => 2, 'name' => 'Test Skill 2'])
        ];

        $trees = (new SkillTreeBuilder($skills))->getTrees();
        expect($trees[0]->getId())->equals($skills[0]->id);
        expect($trees[1]->getId())->equals($skills[1]->id);
    }

    public function testGenerationWithSingleItem()
    {
        $skills = [
            new Skill(['id' => 1, 'name' => 'Test Skill 1']),
        ];

        $trees = (new SkillTreeBuilder($skills))->getTrees();
        expect($trees[0]->getId())->equals($skills[0]->id);
        expect_not($trees[0]->getChildren());
    }
}
