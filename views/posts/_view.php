<?php

use yii\data\ActiveDataProvider;


use yii\helpers\Html;

use yii\widgets\ListView;


/* @var $this yii\web\View */
/* @var $model app\models\Posts */


$js=<<<EOT

$('#botonComentario').on('click', function(){
    var textarea = $(this).prev();
    var texto = textarea.val();

    $.ajax({
        url: '$ruta',
        type:'post',
        data: {
            comentario: texto,
            noticia: '$model->id',
        },
        success: function (data){
            console.log(data)
            console.log($('#comentario'))
            textarea.val(null);
            $('#respuesta').append(data);
        }
    })
})

    $('.posts-view').on('click','.responder',responder);

    function responder (){
        var id = $(this).parent().data('id');
        $(this).after($('<textarea>'));
        var boton = $('<button>');
        boton.text('Enviar');
        boton.addClass('btn btn-xs btn-info enviar');

        comentar(boton,'$rutaPadre','$model->id');

        $(this).after(boton);
        $(this).remove();
    }

EOT;
$this->registerJsFile('/js/comentarios.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($js);
?>
<div class="posts-view">

    <div class="container">
        <div class="row">
            <h3><?=Html::encode($model->titulo)?></h3>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <?=Html::img($model->img)?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <p>
                    <?=Html::encode($model->texto) ?>
                </p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                <textarea name="comentario" rows="5" cols="50"></textarea>
                <input class="btn btn-success" type="button" id="botonComentario" value="Comentar">
            </div>

        </div>
        <hr>
        <div id='respuesta'>
            <?php if ($model->respuestas) {
                echo ListView::widget([
                        'dataProvider' => new ActiveDataProvider([
                            'query' => $model->getRespuestas()->where('padre_id is null')->orderBy('created_at ASC'),
                        ]),
                        'itemView' => '/comentarios/_comentarios',
                        'summary' =>''
                ]);
            } ?>
        </div>

    </div>

</div>
