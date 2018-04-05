<?php

use app\models\EmployeeRole;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $employeeAnalyzer \competencyManagement\employee\EmployeeAnalyzer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = [
    'label' => $model->company->name,
    'url' => ['company/view', 'id' => $model->company_id]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add role', ['employee-role/create', 'employeeId' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Manage skills', ['employee-skill/view', 'employeeId' => $model->id],
            ['class' => 'btn btn-primary']) ?>
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
            'age',
            'gender',
        ],
    ]) ?>

    <h3>Roles</h3>
    <?= GridView::widget([
        'dataProvider' => $employeeRoleDataProvider,
        'filterModel' => $employeeRoleSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'content' => function (EmployeeRole $employeeRole, $key, $index, $column) use ($employeeAnalyzer) {
                    return sprintf(
                        '%s (Competency: %s)',
                        $employeeRole->role->name,
                        Yii::$app->formatter->asPercent($employeeAnalyzer->getEmployeeCompetency($employeeRole->role))
                    );
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['/employee-role/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
