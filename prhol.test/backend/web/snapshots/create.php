<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Snapshots */

$this->title = 'Create Snapshots';
$this->params['breadcrumbs'][] = ['label' => 'Snapshots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snapshots-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
