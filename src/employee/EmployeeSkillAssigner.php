<?php

namespace competencyManagement\employee;

use app\models\EmployeeSkill;
use competencyManagement\skill\SkillTreeModel;

/**
 * @package competencyManagement\skill
 */
class EmployeeSkillAssigner
{
    /**
     * @var SkillTreeModel
     */
    private $skillTrees;

    /**
     * EmployeeSkillAssigner constructor.
     * @param SkillTreeModel[] $skillTrees
     */
    public function __construct(array $skillTrees)
    {
        $this->skillTrees = $skillTrees;
    }

    /**
     * Returns skill tree from Skill models
     * @param EmployeeSkill[] $employeeSkills
     * @return EmployeeSkillAssigner
     */
    public function assignSkillLevels(array $employeeSkills)
    {
        foreach ($this->skillTrees as $id => $skillTree) {
            $this->skillTrees[$id] = $this->assignSkillLevelsRecursively($skillTree, $employeeSkills);
        }
        return $this;
    }

    /**
     * @param SkillTreeModel $skill
     * @param EmployeeSkill[] $employeeSkills
     * @return SkillTreeModel
     */
    private function assignSkillLevelsRecursively(SkillTreeModel $skill, array $employeeSkills)
    {
        foreach ($employeeSkills as $employeeSkill) {
            if ($skill->getId() === $employeeSkill->skill_id) {
                $skill->employeeSkillLevel = $employeeSkill->level;
            }
        }

        foreach ($skill->getChildren() as $child) {
            $this->assignSkillLevelsRecursively($child, $employeeSkills);
        }
        return $skill;
    }


    /**
     * @return SkillTreeModel[]
     */
    public function getSkillTrees(): array
    {
        return $this->skillTrees;
    }
}