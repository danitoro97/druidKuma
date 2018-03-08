<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Noticias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-xs-10 col-xs-offset-1 col-md-5 noticias">
    <h2><?=Html::a(Html::encode($noticia->titulo), ['noticias/view', 'id' => $noticia->id])?></h2>
    <figure>
        <img src="<?=Html::encode($noticia->img)?>" alt="" class="noticia-img img-responsive">
        <figcaption>Publicado por <?=Html::a(
            Html::encode($noticia->creador->nombre),
            ['usuarios/view', 'id' => $noticia->creador->id])?>
            el día <?=Yii::$app->formatter->asDateTime($noticia->created_at)?></figcaption>
    </figure>
    <h3><?=Html::encode($noticia->texto) ?></h3>
</div>
