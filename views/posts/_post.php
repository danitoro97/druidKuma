<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="row ">
    <div class="col-xs-4 col-xs-offset-1">
        <h3><?=Html::encode($model->titulo)?></h3>
    </div>
    <div class="col-xs-4 boton">
        <?=Html::a('Ver detalles', $ruta, ['class' => 'btn btn-xs btn-info'])?>
        <?php if (Yii::$app->user->identity->id == $model->creador_id):?>
            <?=Html::a('Borrar',  ['/posts/delete', 'id' => $model->id, 'ruta' => $rutaIndex], [
                'class' => 'btn btn-xs btn-danger',
                'data' => [
                        'confirm' => '¿Estas seguro que deseas eliminar este post?',
                        'method' => 'post',
                ]
            ])?>
        <?php endif;?>
    </div>
    <div class="col-sm-3 col-xs-4 boton">
        <?= Html::a(Html::encode($model->creador->usuarios->nombre), ['/usuarios/view', 'id' => $model->creador_id])?>
    </div>
    <div class="col-xs-12">
        <hr>
    </div>
</div>
