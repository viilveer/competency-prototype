<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add employee', ['/employee/create', 'companyId' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add role', ['/role/create', 'companyId' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'age',
            'gender',
            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['/employee/'.$action, 'id' => $model->id]);
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

</div>
