<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = 'Create Course';
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = ['label' => $model->company->name, 'url' => ['company/view', 'id' => $model->company_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
