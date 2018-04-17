<?php

namespace competencyManagement\skill;

use app\models\Skill;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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

    /**
     * TODO :: this method should be in speratate presentation class, however in prototype phase this can be here
     * Returns table row presentation
     * @param int $indent defines how many tabulations must be before name (nesting)
     * @return array
     */
    public function getTableRowPresentation($indent = 0): array
    {
        $rows = [];
        $indents = null;
        for ($i = 0; $i < $indent; $i++) {
            $indents .= '&emsp;';
        }
        $rows[] = Html::tag('tr', Html::tag('td', $this->id) .
            Html::tag('td', $indents .
            Html::a($this->name, ['skill/update', 'id' => $this->id])) .
            Html::tag('td', Html::a(
                Html::tag('span',
                    '',
                    ['class' => 'glyphicon glyphicon-trash']),
                ['skill/delete', 'id' => $this->id],
                ['title' => 'Delete', 'data-label' => 'Delete', 'data-confirm' => 'Are you sure you want to delete this item?', 'data-pjax' => 0, 'data-method' => 'post']
            ))
        );
        if ($this->getChildren()) {
            $indent++;
            foreach ($this->getChildren() as $child) {
                $rows = ArrayHelper::merge($rows, $child->getTableRowPresentation($indent));
            }
        }

        return $rows;
    }
}
