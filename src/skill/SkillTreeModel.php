<?php

namespace competencyManagement\skill;

use app\models\Skill;
use yii\base\Model;

class SkillTreeModel extends Model
{
    /**
     * @var float
     */
    public $employeeSkillLevel;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $level;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var SkillTreeModel[]
     */
    protected $children = [];

    /**
     * SkillTreeModel constructor.
     * @param int $level
     * @param Skill $skill provides data to fill in name, description and id
     * @param Skill[] $skills used to find children
     * @param array $config
     */
    public function __construct(int $level, Skill $skill, array $skills, $config = [])
    {
        $this->id = $skill->id;
        $this->name = $skill->name;
        $this->description = $skill->description;
        $this->level = $level;
        $this->findChildren($skills);
        parent::__construct($config);
    }

    /**
     * @param Skill[] $skills
     */
    private function findChildren(array $skills)
    {
        foreach ($skills as $skill) {
            if ($skill->parent_skill_id === $this->id) {
                $this->children[] = new SkillTreeModel($this->level + 1, $skill, $skills);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'description' => $this->description,
            'employeeSkillLevel' => $this->employeeSkillLevel,
            'children' => $this->children
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return SkillTreeModel[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return float
     */
    public function getEmployeeSkillLevel()
    {
        return $this->employeeSkillLevel;
    }
}
