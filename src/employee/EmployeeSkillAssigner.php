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
    private $skillTree;

    /**
     * EmployeeSkillAssigner constructor.
     * @param SkillTreeModel $skillTree
     */
    public function __construct(SkillTreeModel $skillTree)
    {
        $this->skillTree = $skillTree;
    }

    /**
     * Returns skill tree from Skill models
     * @param EmployeeSkill[] $employeeSkills
     * @return EmployeeSkillAssigner
     */
    public function assignSkillLevels(array $employeeSkills)
    {
        $this->skillTree = $this->assignSkillLevelsRecursively($this->skillTree, $employeeSkills);
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
     * @return SkillTreeModel
     */
    public function getSkillTree(): SkillTreeModel
    {
        return $this->skillTree;
    }
}