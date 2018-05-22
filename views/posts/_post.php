<?php

use yii\helpers\Html;

?>

<div class="row ">
    <div class="col-xs-4 col-xs-offset-1">
        <h3><?=Html::encode($model->titulo)?></h3>
    </div>
    <div class="col-xs-4 boton">
        <?=Html::a('Ver detalles', $ruta, ['class' => 'btn btn-xs btn-info'])?>
    </div>
    <div class="col-sm-3 col-xs-4 boton">
        <?= Html::encode($model->creador->usuarios->nombre)?>
    </div>
    <div class="col-xs-12">
        <hr>
    </div>
</div>
