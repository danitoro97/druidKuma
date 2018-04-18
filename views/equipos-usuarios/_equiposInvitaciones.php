<?php

use yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-7">
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
