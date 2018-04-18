<?php

use yii\helpers\Html;


?>

<div class="row">
    <div class="col-md-7">
        <?=Html::encode($model->equipo->nombre)?>
    </div>
    <div class="col-md-2">
        <?=Html::a('Acceder al foro', ['posts/equipo', 'id' => $model->equipo_id])?>
    </div>
</div>
