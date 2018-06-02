<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\helpers\EncodeHelper;




/* @var $this yii\web\View */
/* @var $model app\models\Noticias */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/detallesNoticias.css');
$this->registerCssFile('/css/comentarios.css');
$this->registerJsFile('/js/comentarios.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$ruta = Url::to(['comentarios/create']);
$comentarios = Url::to(['comentarios/view']);
$js= <<<EOT

$('#botonComentario').on('click', function(){
    var textarea = $(this).prev();
    var texto = textarea.val();

    $.ajax({
        url: '$ruta',
        type:'post',
        data: {
            escenario: 'noticia',
            comentario: texto,
            noticia: '$model->id',
        },
        success: function (data){
            textarea.val(null);
            $('#comentario').append(data);
        }
    })
})
$('.noticias-view').on('click','.responder',responder);

function responder (){
    $(this).after($('<textarea>'));
    var boton = $('<button>');
    boton.text('Enviar');
    boton.addClass('btn btn-xs btn-info enviar');

    comentar(boton,'$ruta','$model->id');

    $(this).after(boton);
    $(this).remove();
}

$('#bComentarios').on('click',function(){
    $(this).hide();
    var strAncla='#comentario'
    $.ajax({
        url:'$comentarios',
        type:'get',
        data:{
            id:'$model->id',
            pagination:false,
        },
        success: function (data) {
            var div = $('<div>');
            div.html(data);
            $('#comentario').html(null);
            $('.noticias-view').append(div);

            $('body,html').stop(true,true).animate({
                scrollTop: $(strAncla).offset().top
            },1000);
        }
    })
})

EOT;

$this->registerJs($js);
?>
<div class="noticias-view">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-7">
                <?=Html::button('Ver comentarios', ['class' => 'btn btn-info', 'id' =>'bComentarios','data-ancla' => '#comentario'])?>
            </div>
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

        <?php endif; ?>
        <div id="comentario">

        </div>
    </div>
</div>
