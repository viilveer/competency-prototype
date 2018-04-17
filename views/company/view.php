<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $skillTrees \competencyManagement\skill\SkillTreeModel[] */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add employee', ['/employee/create', 'companyId' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add skill', ['/skill/create', 'companyId' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add role', ['/role/create', 'companyId' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add course', ['/course/create', 'companyId' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add competency model', ['/competency-model/create', 'companyId' => $model->id], ['class' => 'btn btn-primary']) ?>
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
        ],
    ]) ?>
    <h3>Employees</h3>
    <?= GridView::widget([
        'dataProvider' => $employeeDataProvider,
        'filterModel' => $employeeSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['/employee/'.$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <h3>Skills</h3>
    <div id="w100" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Skill</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($skillTrees as $skillTree) {
                echo implode('' , $skillTree->getTableRowPresentation());
//                echo Html::tag(
//                    'tr',
//                    sprintf(
//                        '%s%s%s',
//                        Html::tag('td'),
//                        Html::tag('td', $skillTree->->name),
//                        Html::tag('td', Html::textInput('skill', $employeeSkill ? $employeeSkill->level : null, ['class' => 'form-control']))
//                    ),
//                    ['data-update' => \yii\helpers\Url::to(['employee-skill/update', 'employeeId' => $employeeId, 'skillId' => $skill->id])]
//                );
            }
            ?>
            </tbody>
        </table>
    </div>

    <h3>Competency models</h3>
    <?= GridView::widget([
        'dataProvider' => $competencyDataProvider,
        'filterModel' => $competencyModelSearchForm,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'type',
            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['/competency-model/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <h3>Roles</h3>
    <?= GridView::widget([
        'dataProvider' => $roleDataProvider,
        'filterModel' => $roleSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['/role/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <h3>Courses</h3>
    <?= GridView::widget([
        'dataProvider' => $courseDataProvider,
        'filterModel' => $courseSearchForm,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['/course/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
