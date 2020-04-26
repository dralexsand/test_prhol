<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Params';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="params-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Params', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'count_apples',
            'time_to_disappearance:datetime',
            'unit',
            //'offset_distanse_between_items',
            //'length_generation_id',
            //'time_offset_new_generation_element:datetime',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
