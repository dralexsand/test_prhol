<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Params */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="params-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count_apples')->textInput() ?>

    <?= $form->field($model, 'time_to_disappearance')->textInput() ?>

    <?= $form->field($model, 'unit')->textInput() ?>

    <?= $form->field($model, 'offset_distanse_between_items')->textInput() ?>

    <?= $form->field($model, 'length_generation_id')->textInput() ?>

    <?= $form->field($model, 'time_offset_new_generation_element')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
