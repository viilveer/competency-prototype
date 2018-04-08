<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmployeeCourse */
/* @var $course \app\models\Course */

$this->title = 'Create Employee Course';
$this->params['breadcrumbs'][] = ['label' => 'Employee Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'course' => $course,
    ]) ?>

</div>
