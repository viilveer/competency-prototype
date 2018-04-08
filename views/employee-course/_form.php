<?php

use app\models\Employee;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeCourse */
/* @var $form yii\widgets\ActiveForm */
/* @var $course \app\models\Course */
?>

<div class="employee-course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->dropDownList(ArrayHelper::map(Employee::findAll(['company_id' => $course->company_id]), 'id', 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
