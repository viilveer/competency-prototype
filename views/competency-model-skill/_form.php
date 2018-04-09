<?php

use app\models\Skill;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CompetencyModelSkill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="competency-model-skill-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'skill_id')->dropDownList(ArrayHelper::map(Skill::findAll(['company_id' => $model->competencyModel->company_id]), 'id', 'name')) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
