<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompetencyModel */

$this->title = 'Update Competency Model: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = ['label' => $model->company->name, 'url' => ['company/view', 'id' => $model->company_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="competency-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
