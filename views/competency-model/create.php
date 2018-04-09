<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CompetencyModel */

$this->title = 'Create Competency Model';
$this->params['breadcrumbs'][] = ['label' => 'Competency Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competency-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
