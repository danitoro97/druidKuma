<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
/* @var app\models\Comentarios */
$this->registerCssFile('/css/comentarios.css');


?>

<div class="row" >
    <div class="col-md-5 col-md-offset-2 comentario" data-padre_id = <?=$model->id?>>
        <p class="usuario">
            <span class="nombre_usuario">
                <?=Html::encode($model->usuario->nombre)?>
            </span>
        </p>
        <p>
            <?=Html::encode($model->texto)?>
        </p>
        
    </div>

</div>
