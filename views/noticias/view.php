<?php

use yii\helpers\Html;
use app\helpers\EncodeHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Noticias */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/detallesNoticias.css');
?>
<div class="noticias-view">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-3">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-9 col-md-offset-3">
                <h3><?= Html::encode($model->subtitulo)?></h3>
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
            <div class="col-md-10 col-md-offset-1">
                <p>
                    <?=EncodeHelper::encode($model->texto) ?>
                </p>
            </div>

        </div>
    </div>







</div>
