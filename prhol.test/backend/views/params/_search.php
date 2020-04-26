<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ParamsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="params-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'count_apples') ?>

    <?= $form->field($model, 'time_to_disappearance') ?>

    <?= $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'offset_distanse_between_items') ?>

    <?php // echo $form->field($model, 'length_generation_id') ?>

    <?php // echo $form->field($model, 'time_offset_new_generation_element') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
