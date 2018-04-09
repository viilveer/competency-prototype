<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = ['label' => 'Opus', 'url' => ['company/view', 'id' => $model->company_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'name',
            'competencyModel.name:ntext:Competency Model',
            'description:ntext',
        ],
    ]) ?>

</div>

<div id="w0" class="grid-view">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Skill</th>
            <th>Needed Level</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($model->competencyModel->competencyModelSkills as $competencyModelSkill) {
            /** @var \app\models\RoleSkill $roleSkill */
            $roleSkill = ArrayHelper::getValue(ArrayHelper::index($model->roleSkills, 'competency_model_skill_id'), $competencyModelSkill->id);
            echo Html::tag(
                'tr',
                sprintf(
                    '%s%s%s',
                    Html::tag('td'),
                    Html::tag('td', $competencyModelSkill->skill->name),
                    Html::tag('td', Html::textInput('skill', $roleSkill ? $roleSkill->level : null, ['class' => 'form-control']))
                ),
                ['data-update' => \yii\helpers\Url::to(['role/skill-update', 'competencyModelSkillId' => $competencyModelSkill->id, 'roleId' => $model->id])]
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
