<?php

use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Equipos';
$this->params['breadcrumbs'][] = $this->title;
$rutaAceptar = Url::to(['/participantes/aceptar-peticion']);
$rutaRechazar = Url::to(['/participantes/delete']);
$js = <<<EOT

$('.glyphicon-ok').parent().on('click', function(){
    var id = $(this).parent().prev().data('id');
    var div = $(this).parent().parent();

    $.ajax({
        url:'$rutaAceptar',
        type:'post',
        data: {
            equipo_id:id
        },
        success: function (data) {
            aceptar(data,div);
        }
    });
})

$('.glyphicon-remove').parent().on('click', function(){
    var id = $(this).parent().prev().prev().data('id');
    var div = $(this).parent().parent();

    $.ajax({
        url:'$rutaRechazar',
        type:'post',
        data: {
            equipo_id:id
        },
        success: function (data) {
            if (data) {
                rechazar(div);
            }
        }
    });
})

EOT;

$this->registerJs($js);
$this->registerCssFile('/css/equiposUsuarios.css');
?>
<div class="equipos-usuarios-index">
    <div class="container col-md-8 col-md-offset-2">
        <div class="col-md-12 text-center">
            <h3>Mis equipos</h3>
        </div>
        <div class="row">
            <?php
                if ($model == null) {
                    echo $this->render('_guia');
                } else {
                    echo Html::a('Crear equipo', '/equipos-usuarios/create', ['class' => 'col-xs-offset-9 btn btn-success']);
                }
            ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php foreach ($model as $m) : ?>
                    <?php
                        $ruta = ($m->aceptar) ? '_equiposDisponibles' : '_equiposInvitaciones';
                    ?>
                    <?= $this->render($ruta,['model' => $m]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>



</div>
