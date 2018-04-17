<?php


/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\web\View;

/* @var $employeeId int */
/* @var $skills \app\models\Skill[] */
/* @var $employeeSkills \app\models\EmployeeSkill[] */
/* @var $employee \app\models\Employee */

$this->title = 'Manage skills';

$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = ['label' => $employee->company->name, 'url' => ['company/view', 'id' => $employee->company_id]];
$this->params['breadcrumbs'][] = ['label' => $employee->name, 'url' => ['employee/view', 'id' => $employee->id]];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.js',
    ['position' => View::POS_HEAD]
);
$this->registerJsFile(
    '@web/js/scripts.js',
    ['position' => View::POS_HEAD, 'depends' => [JqueryAsset::class]]
);

$this->registerCssFile('//visjs.org/dist/vis-timeline-graph2d.min.css');

?>
<h2>Skill hierarchy</h2>
<div id="tree" style="height: 400px" data-remote-url="<?= \yii\helpers\Url::to(['employee-skill/tree', 'employeeId' => $employeeId]) ?>"></div>
<h2>Skill assigner</h2>
<div id="w0" class="grid-view">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Skill</th>
            <th>Level</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($skills as $skill) {
            $employeeSkill = \yii\helpers\ArrayHelper::getValue($employeeSkills, $skill->id);
            echo Html::tag(
                'tr',
                sprintf(
                    '%s%s%s',
                    Html::tag('td'),
                    Html::tag('td', $skill->name),
                    Html::tag('td', Html::textInput('skill', $employeeSkill ? $employeeSkill->level : null, ['class' => 'form-control']))
                ),
                ['data-update' => \yii\helpers\Url::to(['employee-skill/update', 'employeeId' => $employeeId, 'skillId' => $skill->id])]
            );
        }
        ?>
        </tbody>
    </table>
</div>
<h2>Skill levels in time</h2>
<div id="2dgraph" style="height: 400px" data-remote-url="<?= \yii\helpers\Url::to(['employee-skill/json', 'employeeId' => $employeeId]) ?>"></div>