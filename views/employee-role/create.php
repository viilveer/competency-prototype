<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $companyRoles array */
/* @var $model app\models\EmployeeRole */

$this->title = 'Create Employee Role';
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = ['label' => $model->employee->company->name, 'url' => ['company/view', 'id' => $model->employee->company_id]];
$this->params['breadcrumbs'][] = ['label' => $model->employee->name, 'url' => ['employee/view', 'id' => $model->employee_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'companyRoles' => $companyRoles
    ]) ?>

</div>
