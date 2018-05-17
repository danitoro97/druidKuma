<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Noticias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-xs-12 col-xs-offset-0 col-md-5 noticias">
    <h2><?=Html::a(Html::encode($noticia->titulo), ['noticias/view', 'id' => $noticia->id])?></h2>
    <figure>
        <img src="<?=Html::encode($noticia->img)?>" alt="" class="noticia-img img-responsive">
        <figcaption>Publicado por <?php
            if ($noticia->creador): ?>
            <?= Html::a(
                Html::encode($noticia->creador->nombre),
                ['usuarios/view', 'id' => $noticia->creador->id])
            ?>
        <?php endif; ?>
            el día <?=Yii::$app->formatter->asDateTime($noticia->created_at)?></figcaption>
    </figure>
    <h3><?=Html::encode($noticia->subtitulo) ?></h3>
</div>
