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
        <div class="col-xs-2 col-xs-offset-1">
            <?= Html::img($model->local->url, ['class' => 'img-responsive escudo']) ?>
        </div>
        <div class="col-xs-4 col-xs-offset-1">
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
        <div class="col-xs-2">
            <?= Html::img($model->visitante->url, ['class' => 'img-responsive escudo']) ?>
        </div>
    </div>

</div>
