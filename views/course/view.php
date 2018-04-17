<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = [
    'label' => $model->company->name,
    'url' => ['company/view', 'id' => $model->company_id]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add Employee', ['employee-course/create', 'courseId' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'company_id',
            'name',
        ],
    ]) ?>

    <h3>Employees</h3>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $employeeCourseDataProvider,
        'filterModel' => $employeeCourseSearch,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'employee.name',
            'status',

            [
                'buttons' => [
                    'mark-as-completed' => function ($url, \app\models\EmployeeCourse $model, $key) {
                        return $model->status === 'STARTED' ? Html::a('Mark as finished', $url) : '';
                    },
                ],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{mark-as-completed} {view} {delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['/employee-course/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
</div>
