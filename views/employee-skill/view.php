<?php


/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\web\View;

/* @var $employeeId int */
/* @var $skills \app\models\Skill[] */
/* @var $employeeSkills \app\models\EmployeeSkill[] */

$this->title = 'Employee Skills';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.js',
    ['position' => View::POS_HEAD]
);
$this->registerJsFile(
    '@web/js/scripts.js',
    ['position' => View::POS_HEAD, 'depends' => [JqueryAsset::class]]
);

?>

<div id="tree" style="height: 400px" data-remote-url="<?= \yii\helpers\Url::to(['employee-skill/tree', 'employeeId' => $employeeId]) ?>"></div>
<div id="w0" class="grid-view">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Skill</th>
            <th>Level</th>
            <th class="action-column">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($skills as $skill) {
            $employeeSkill = \yii\helpers\ArrayHelper::getValue($employeeSkills, $skill->id);

            echo Html::tag(
                'tr',
                sprintf(
                    '%s%s%s%s',
                    Html::tag('td'),
                    Html::tag('td', $skill->name),
                    Html::tag('td', Html::textInput('skill', $employeeSkill ? $employeeSkill->level : null, ['class' => 'form-control'])),
                    Html::tag('td', Html::a('Update', ['employee-skill/update', 'employeeId' => $employeeId, 'skillId' => $skill->id], ['class' => 'js-update']))
                )
            );
        }
        ?>
        </tbody>
    </table>
</div>