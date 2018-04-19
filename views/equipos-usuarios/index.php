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
?>
<div class="equipos-usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

        if ($model == null) {
            echo $this->render('_guia');
        }
    ?>


    <?php foreach ($model as $m) : ?>
        <?php
            $ruta = ($m->aceptar) ? '_equiposDisponibles' : '_equiposInvitaciones';
        ?>
        <?= $this->render($ruta,['model' => $m]) ?>
    <?php endforeach; ?>

</div>
