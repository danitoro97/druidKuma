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
                <?=Html::encode($model->creadorNombre)?>
            </span>
        </p>
        <p>
            <?=Html::encode($model->texto)?>
        </p>
        <?php if(!Yii::$app->user->isGuest) : ?>
            <?=Html::button('Responder', ['class' => 'btn-xs btn-info responder']) ?>
        <?php endif;?>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 comentario">
            <?php if ($model->respuestas) {
                echo ListView::widget([
                        'dataProvider' => new ActiveDataProvider([
                            'query' => $model->getRespuestas()->orderBy('created_at ASC'),
                        ]),
                        'itemView' => '_respuestas',
                        'summary' =>''
                ]);
            } ?>
        </div>
    </div>


</div>
