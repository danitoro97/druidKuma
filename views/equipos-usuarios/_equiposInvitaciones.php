<?php

use yii\helpers\Html;

$this->registerJsFile('/js/invitaciones.js' ,['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="row">
    <div class="col-md-7" data-id='<?=$model->equipo->id?>'>
        El equipo <?=Html::encode($model->equipo->nombre)?> le ha invitado a participar
    </div>
    <div class="col-md-2">
        <a href="#">
            <span class="glyphicon glyphicon-ok"></span>
        </a>
    </div>
    <div class="col-md-2">
        <a href="#">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </div>
</div>
