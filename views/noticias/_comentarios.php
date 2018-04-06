<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;
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
    <div class="row">
        <div class="col-md-10 col-md-offset-2 comentario">
            <?php if ($model->comentarios) {
                echo ListView::widget([
                        'dataProvider' => new ActiveDataProvider([
                            'query' => $model->getComentarios()->orderBy('created_at ASC'),
                        ]),
                        'itemView' => '_comentarios',
                        'summary' =>''
                ]);
            } ?>
        </div>
    </div>


</div>
