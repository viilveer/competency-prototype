<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeCourse */
/* @var $employeeCourseSkills \app\models\EmployeeCourseSkill[] */
/* @var $employeeSkills \app\models\EmployeeSkill[] */
/* @var $skills \app\models\Skill[] */

$this->title = sprintf('Manage employee %s course %s',  $model->employee->name, $model->course->name);
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = [
    'label' => $model->employee->company->name,
    'url' => ['company/view', 'id' => $model->employee->company_id]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->course->name,
    'url' => ['course/view', 'id' => $model->course_id]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-course-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'employee.name',
            'course.name',
            'status',
        ],
    ]) ?>

</div>

<div id="w0" class="grid-view">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Skill</th>
            <th>Current Level</th>
            <th>After course level</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($skills as $skill) {
            /** @var \app\models\EmployeeCourseSkill $employeeCourseSkill */
            $employeeCourseSkill = \yii\helpers\ArrayHelper::getValue($employeeCourseSkills, $skill->id);
            $employeeSkill = \yii\helpers\ArrayHelper::getValue($employeeSkills, $skill->id);
            echo Html::tag(
                'tr',
                sprintf(
                    '%s%s%s%s',
                    Html::tag('td'),
                    Html::tag('td', $skill->name),
                    Html::tag('td', $employeeSkill ? $employeeSkill->level : 0),
                    Html::tag('td', Html::textInput('skill', $employeeCourseSkill ? $employeeCourseSkill->modifier : null, ['class' => 'form-control']))
                ),
                ['data-update' => \yii\helpers\Url::to(['employee-course-skill/update', 'employeeCourseId' => $model->id, 'skillId' => $skill->id])]
            );
        }
        ?>
        </tbody>
    </table>
</div>
<script>
    $(document).on('keyup', 'input.form-control', function () {
        var skillLevel = $(this).val();
        $.post($(this).parents('tr').data('update'), { skillLevel }, function (data) {
        });

        return false;
    });
</script>
