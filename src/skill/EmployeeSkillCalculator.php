<?php

namespace competencyManagement\skill;

use app\models\EmployeeSkill;
use app\models\Skill;
use yii\helpers\ArrayHelper;

/**
 * SkillTreeBuilder class is used to generate tree from flat array of Skill models
 * @package competencyManagement\skill
 */
class EmployeeSkillCalculator
{
    /**
     * @var Skill[]
     */
    private $skillsFlat;
    /**
     * @var EmployeeSkill[]
     */
    private $employeeSkills = [];

    /**
     * @var EmployeeSkill[]
     */
    private $virtualEmployeeSkills = [];

    /**
     * EmployeeSkillAssigner constructor.
     * @param Skill[] $skillsFlat
     * @param EmployeeSkill[] $employeeSkills
     */
    public function __construct(array $skillsFlat, array $employeeSkills)
    {
        $this->skillsFlat = ArrayHelper::index($skillsFlat, 'id');
        $this->employeeSkills = ArrayHelper::index($employeeSkills, 'skill_id');
    }

    /**
     * Creates placeholders for employee missing skills
     */
    private function createVirtualSkills()
    {
        $skillIds = array_keys($this->skillsFlat);
        $employeeSkillIds = array_keys($this->employeeSkills);

        $missingSkillIds = array_diff($skillIds, $employeeSkillIds);

        foreach ($missingSkillIds as $id) {
            $employeeSkill = new EmployeeSkill();
            $employeeSkill->skill_id = $id;
            $this->virtualEmployeeSkills[$id] = $employeeSkill;
        }
    }

    /**
     * Calculates employee skills by first going upwards in skill tree and then downwards
     */
    private function calculateSkills()
    {
        foreach ($this->skillsFlat as $skill) {
            $employeeSkill = ArrayHelper::getValue($this->employeeSkills, $skill->id);
            if ($employeeSkill instanceof EmployeeSkill) {
                $parentSkill = ArrayHelper::getValue($this->skillsFlat, $skill->parent_skill_id);
                // might be root node
                if ($parentSkill) {
                    $this->processSkillUpwards($parentSkill, $employeeSkill->level);
                }
            }
        }

        $this->processSkillsDownwards();
    }

    /**
     * Calculates skills upwards in the skill tree
     * @param Skill $skill Skill to be processed
     * @param float $level previous skill level
     */
    private function processSkillUpwards(Skill $skill, float $level)
    {
        /** @var EmployeeSkill $calculatedSkill */
        $calculatedSkill = ArrayHelper::getValue($this->virtualEmployeeSkills, $skill->id);
        // this is probably decision point, to calculate up when virtual is not found or not
        if ($calculatedSkill) {
            $calculatedSkill->level = $level / 2;

            if ($skill->parent_skill_id) {
                $parentSkill = ArrayHelper::getValue($this->skillsFlat, $skill->parent_skill_id);
                $this->processSkillUpwards($parentSkill, $calculatedSkill->level);
            }
        }
    }

    /**
     * Calculates skills downwards recursively until no skills left to process
     */
    private function processSkillsDownwards()
    {
        while (($employeeSkill = $this->getSkillWithoutLevel()) !== null) {
            $parentSkillId = ArrayHelper::getValue($this->skillsFlat, $employeeSkill->skill_id)->parent_skill_id;
            $parentEmployeeSkill = $this->getEmployeeSkill($parentSkillId);
            if ($parentEmployeeSkill && $parentEmployeeSkill->level) {
                $employeeSkill->level = $parentEmployeeSkill->level / 4;
                $this->virtualEmployeeSkills[$employeeSkill->skill_id] = $employeeSkill;
            }
        }
    }

    /**
     * Finds employee skill from calculated and non-calculated containers
     * @param int $skillId
     * @return EmployeeSkill
     */
    private function getEmployeeSkill(int $skillId)
    {
        return ArrayHelper::getValue(
            $this->employeeSkills,
            $skillId,
            ArrayHelper::getValue($this->virtualEmployeeSkills, $skillId, null)
        );
    }

    /**
     * Finds skill which does not have calculated level
     * @return EmployeeSkill
     */
    private function getSkillWithoutLevel()
    {
        foreach ($this->virtualEmployeeSkills as $employeeSkill) {
            if ($employeeSkill->level === null) {
                return $employeeSkill;
            }
        }
        return null;
    }

    /**
     * Calculates and then returns all employee skills
     * @return EmployeeSkill[]
     */
    public function getEmployeeCalculatedSkills(): array
    {
        if (count($this->employeeSkills)) {
            $this->createVirtualSkills();
            // nothing to calculate when employee does not have anything
            $this->calculateSkills();
        }
        return array_values($this->virtualEmployeeSkills);
    }
}