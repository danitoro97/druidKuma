<?php

use app\models\Equipos;
use yii\data\ActiveDataProvider;

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ListView;


/* @var $this yii\web\View */
/* @var $model app\models\Partidos */
/*
$this->title = $model->local->nombre . ' - ' . $model->visitante->nombre;
$this->params['breadcrumbs'][] = ['label' => $model->liga->nombre, 'url' => ['/ligas/view','id' => $model->liga_id]];
$this->params['breadcrumbs'][] = $this->title;*/
$this->registerJsFile('js/ventana.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$css=<<<EOT
    .escudo {
        max-width: 165px;
        max-height: 165px;
    }

    h2,h3 {
        text-align: center;
    }

    input {
        margin-top:10px;
        border-radius: 5px;
       	border: 1px solid black;
    }
    .comentario {
        text-align:center;
    }
EOT;

$this->registerCss($css);
$ruta= Url::to(['/comentar-partidos/create']);
$js=<<<EOT

    $('#boton').on('click',function(e){
        e.preventDefault();
        var texto = $(this).prev().val();
        $(this).prev().val(null);
        var div = $(this).parent().parent();
        $.ajax({
            url:'$ruta',
            type:'post',
            data:{
                partido_id:'$model->id',
                texto:texto
            },
            success: function(data) {
                if (data != false) {
                    div.append(data);
                    window.opener.comentado('$model->id');
                }
            }
        })
    })

EOT;


$this->registerJs($js);
?>
<div class="partidos-view">

    <div class="row">
        <div class="col-xs-12 col-sm-2 col-sm-offset-1">
            <?= Html::img($model->local->escudo, ['class' => 'img-responsive escudo']) ?>
        </div>
        <div class="col-xs-12 col-sm-4 col-sm-offset-1">
            <?php
                if ($model->estado == Equipos::FINALIZADO): ?>
                 <h2><?=$model->goles_local ?? '0'?> - <?=$model->goles_visitante ?? '0' ?></h2>
                 <h3>FINALIZADO</h3>
                 <?php
                 foreach ($model->detalles as $key) : ?>
                     <h4>
                        <?= $key->jugador->nombre; ?>
                        <?= ($key->roja) ? 'roja' : '' ?>
                        <?= ($key->amarilla) ? 'amarilla' : '' ?>
                        <?= ($key->gol) ? 'gol' : '' ?>
                        <?= ($key->autogol) ? 'gol en propia' : ''?>
                        <?= $key->minuto . '\'' ?>
                    </h4>
                 <?php endforeach ; ?>

            <?php else : ?>

                <h3>POR JUGAR</h3>
            <?php endif; ?>

            <h3><?=Yii::$app->formatter->asDate($model->fecha)?></h3>
            <h3><?=$model->liga->nombre?></h3>
        </div>
        <div class="col-xs-12 col-sm-2">
            <?= Html::img($model->visitante->escudo, ['class' => 'img-responsive escudo']) ?>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 comentario ">
                <div class="row">
                    <div class="col-md-7 col-md-offset-2">
                        <textarea name="comentario" rows="5" cols="30"></textarea>
                        <input type="button" id="boton" value="Comentar" class="btn-xs btn-info responder">
                    </div>
                </div>
                <?php if ($model->comentarPartidos) {
                    echo ListView::widget([
                            'dataProvider' => new ActiveDataProvider([
                                'query' => $model->getComentarPartidos()->orderBy('created_at ASC'),
                            ]),
                            'itemView' => '/comentarios/_comentarios',
                            'viewParams' => ['padre' => true],
                            'summary' =>''
                    ]);
                } ?>
            </div>
        </div>
    </div>

</div>
