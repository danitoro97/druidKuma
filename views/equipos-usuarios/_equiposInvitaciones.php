<?php

use yii\helpers\Html;

$this->registerJsFile('/js/invitaciones.js' ,['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="row invitacion">
    <div class="col-md-7" data-id='<?=$model->equipo->id?>'>
        <h3> <?=Html::encode($model->equipo->nombre)?> le ha invitado a participar</h3>
    </div>
    <div class="col-md-2 text-center">
        <a href="#">
            <span class="glyphicon glyphicon-ok"></span>
        </a>
    </div>
    <div class="col-md-2 text-center">
        <a href="#">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
</div>
