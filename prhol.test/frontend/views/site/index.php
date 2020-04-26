<?php

/* @var $this yii\web\View */

$this->title = 'Apples Evolution';
?>


<div class="jumbotron">
    <p class="lead">Lets harvest!</p>
    <p>
        <button id="generate_harvest" class="btn btn-lg btn-success">Генерировать</button>
        <button id="save_harvest" class="btn btn-lg btn-success">Сохранить</button>
    </p>
</div>

<!--Counter:-->
<div class="hidden" id="counter"></div>

<div id="timemessage"></div>

<div id="storage"></div>


<div class="hidden" id="generation_id"><?= $generation_id ?></div>
<div class="hidden" id="unit"><?= $unit ?></div>
<div class="hidden" id="time_to_disappearance"><?= $time_to_disappearance ?></div>
<div class="hidden" id="items_data"><?= $items_data ?></div>

<div id="status-area"></div>

<div id="description" class="row"></div>

<div class="body-content">
    <div id="content" class="content" style="width:<?= $width_content ?>px;height:<?= $height_content ?>px;">
        <?= $content ?>
    </div>


</div>

