<?php

use yii\helpers\Html;

?>

<div class="row ">
    <div class="col-xs-4 col-xs-offset-1">
        <h3><?=Html::encode($model->equipo->nombre)?></h3>
    </div>
    <div class="col-xs-4 boton">
        <?=Html::a('Acceder al foro', ['posts/index', 'id' => $model->equipo_id], ['class' => 'btn btn-xs btn-info'])?>
    </div>
    <div class="col-sm-3 col-xs-4 boton">
        <?php
            if ($model->equipo->creador_id == Yii::$app->user->identity->id) : ?>
                <?=Html::a('Añadir participantes', ['/participantes/create', 'equipoId' => $model->equipo_id], ['class' => 'btn btn-xs btn-info'])?>
                <?=Html::a('Eliminar equipo', ['/equipos-usuarios/delete', 'id' => $model->equipo_id], [
                    'class' => 'btn btn-xs btn-danger',
                    'data' => [
                            'confirm' => '¿Estas seguro que deseas eliminar este equipo?',
                            'method' => 'post',
                            ]
                    ])?>
        <?php else : ?>
            <?=Html::a('Abandonar equipo', ['/participantes/abandonar', 'id' => $model->equipo_id], [
                'class' => 'btn btn-xs btn-danger',
                'data' => [
                        'confirm' => '¿Estas seguro que deseas abandonar este equipo?',
                        'method' => 'post',
                        ]
                ])?>
        <?php endif; ?>
    </div>
    <div class="col-xs-12">
        <hr>
    </div>
</div>
