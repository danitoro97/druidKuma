<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\helpers\EncodeHelper;
use yii\widgets\ListView;



/* @var $this yii\web\View */
/* @var $model app\models\Noticias */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/detallesNoticias.css');
$ruta = Url::to(['comentarios/create']);
$js= <<<EOT
    $('#botonComentario').on('click', function(event){
        event.preventDefault();
        var textarea = $(this).prev();
        var comentario = textarea.val();

        if (comentario != ''){
            $.ajax({
                url: '$ruta',
                type: 'post',
                data: {
                    comentario: comentario,
                    noticia: '$model->id',
                },
                success: function(data){
                    //Añadir comentario al div
                    textarea.val('');
                },
                dataType : 'json',
            });
        }

    });
EOT;

$this->registerJs($js);
?>
<div class="noticias-view">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-3 ">
                <h1><?= Html::encode($this->title) ?></h1>

            </div>
            <div class="col-md-9 col-md-offset-3">
                <h3><?= Html::encode($model->subtitulo)?></h3>
                <hr>
            </div>
            <div class="">
                <?=Html::img($model->img, ['class' => 'centrar img-responsive'])?>

            </div>
            <div class="col-md-9 col-md-offset-3">
                <p>
                    Creador por <?=Html::a($model->creador->nombre,['usuarios/view','id' => $model->creador_id])?>
                    el día <?=Yii::$app->formatter->asDatetime($model->created_at)?>
                </p>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <hr>
                <p>
                    <?=EncodeHelper::encode($model->texto) ?>
                </p>
            </div>
        </div>
        <?php
         if (!Yii::$app->user->isGuest) : ?>
            <div class="row">
                <div class="col-md-7 col-md-offset-2">
                    <textarea name="comentario" rows="5" cols="50"></textarea>
                    <input class="btn btn-success" type="button" id="botonComentario" value="Comentar">
                </div>

            </div>

        <?php endif;
            echo '<h3>Comentarios</h3>';
            echo ListView::widget([
                    'dataProvider' => $comentarios,
                    'itemView' => '_comentarios',
                    'summary' =>''
            ]);

        ?>
    </div>







</div>
