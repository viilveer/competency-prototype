<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompetencyModelSkill */

$this->title = 'Update Competency Model Skill: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = ['label' => $model->competencyModel->company->name, 'url' => ['company/view', 'id' => $model->competencyModel->company_id]];
$this->params['breadcrumbs'][] = ['label' => $model->competencyModel->name, 'url' => ['view', 'id' => $model->competencyModel->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="competency-model-skill-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
