<?php

use yii\helpers\Html;
/* @var app\models\Comentarios */
$this->registerCssFile('/css/comentarios.css');
?>

<div class="row">
    <div class="col-md-5 col-md-offset-2 comentario">
        <p class="usuario">
            <span class="nombre_usuario">
                <?=($model->usuario->usuarios) ? Html::a(
                    Html::encode($model->usuario->usuarios->nombre), ['usuarios/view', 'id' => $model->usuario_id])
                 : 'anonimo'?>
            </span>
            <span class="fecha">
                <?=Yii::$app->formatter->asDatetime($model->created_at)?>
            </span>
        </p>
        <p>
            <?=Html::encode($model->comentario)?>
        </p>
    </div>

</div>
