<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CompetencyModel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = [
    'label' => $model->company->name,
    'url' => ['company/view', 'id' => $model->company_id]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competency-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add skill', ['/competency-model-skill/create', 'competencyModelId' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'company.name',
            'name',
            'type',
        ],
    ]) ?>

    <h3>Skills</h3>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $competencyModelDataProvider,
        'filterModel' => $competencyModelSkillSearch,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'skill.name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return \yii\helpers\Url::to(['/competency-model-skill/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
