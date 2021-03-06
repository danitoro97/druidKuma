<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
/* @var app\models\Comentarios */
$this->registerCssFile('@web/css/comentarios.css');
?>

<div class="row" >
    <div class="col-md-5 col-md-offset-2 comentario" data-padre_id = <?=$model->id?>>
        <p class="usuario">
            <span class="nombre_usuario">
            <?php

                $nombre = ($model->usuario->usuarios) ? Html::a(
                    Html::encode($model->usuario->usuarios->nombre), ['/usuarios/view', 'id' => $model->usuario_id])
                 : 'anonimo';

            ?>
                <?=$nombre?>
            </span>
            <span class="fecha">
                <?=Yii::$app->formatter->asDatetime($model->created_at)?>
            </span>
        </p>
        <p>
            <?php
                if (isset($model->padre_id)){
                    echo '#' . Html::a(Html::encode($model->padre->usuario->usuarios->nombre) , ['/usuarios/view', 'id' => $model->padre->usuario_id]);
                }
            ?>
            <?=Html::encode($model->comentario)?>
        </p>
        <?php if(!Yii::$app->user->isGuest && !isset($padre)) : ?>
            <?=Html::button('Responder', ['class' => 'btn-xs btn-info responder']) ?>
        <?php endif;?>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 comentario">
            <?php if (!isset($padre) && $model->comentarios) {
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
