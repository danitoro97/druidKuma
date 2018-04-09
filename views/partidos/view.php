<?php

use app\models\Equipos;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Partidos */

$this->title = $model->local->nombre . ' - ' . $model->visitante->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Partidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$css=<<<EOT
    .escudo {
        max-width: 165px;
        max-height: 165px;
    }

    h2,h3 {
        text-align: center;
    }
EOT;

$this->registerCss($css);
?>
<div class="partidos-view">

    <div class="row">
        <div class="col-xs-12 col-sm-2 col-sm-offset-1">
            <?php $logo = $model->local->url == null ? Equipos::LOGO_DEFAULT : $model->local->url?>
            <?= Html::img($logo, ['class' => 'img-responsive escudo']) ?>
        </div>
        <div class="col-xs-12 col-sm-4 col-sm-offset-1">
            <?php
                if ($model->estado == Equipos::FINALIZADO): ?>
                 <h2><?=$model->goles_local ?? '0'?> - <?=$model->goles_visitante ?? '0' ?></h2>
                 <h3>FINALIZADO</h3>

            <?php else : ?>
                <h3>POR JUGAR</h3>
            <?php endif; ?>

            <h3><?=Yii::$app->formatter->asDate($model->fecha)?></h3>
            <h3><?=$model->liga->nombre?></h3>
        </div>
        <div class="col-xs-12 col-sm-2">
            <?php $logo = $model->visitante->url == null ? Equipos::LOGO_DEFAULT : $model->visitante->url?>
            <?= Html::img($logo, ['class' => 'img-responsive escudo']) ?>
        </div>
    </div>

</div>
