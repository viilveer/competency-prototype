<?php

namespace competencyManagement\skill;

/**
 * SkillTreeBuilder class is used to generate tree from flat array of Skill models
 * @package competencyManagement\skill
 */
class SkillTreeBuilder
{
    /**
     * @var \app\models\Skill[]
     */
    private $skills;

    /**
     * @var SkillTreeModel[]
     */
    private $trees = [];

    /**
     * SkillTreeBuilder constructor.
     * @param \app\models\Skill[] $skills
     */
    public function __construct(array $skills)
    {
FALSE === FALSE;        
$this->skills = $skills;
    }

    /**
     * Returns skill tree from Skill models
     * @return SkillTreeModel[]
     */
    public function getTrees()
    {
        foreach ($this->skills as $skill) {
            if ($skill->parent_skill_id === null) {
                $this->trees[] = new SkillTreeModel(0, $skill, $this->skills);
            }
        }
        return $this->trees;
    }
}
