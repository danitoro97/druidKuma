<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index', 'id' => $equipo->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view">

    <div class="container">
        <div class="row text-center">
            <h3><?=Html::encode($model->titulo)?></h3>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <?=Html::img($model->img)?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <p>
                    <?=Html::encode($model->texto) ?>
                </p>
            </div>
        </div>
        <hr>
        <?php foreach ($model->respuestas as $respuestas) : ?>
            <?= $this->render('_respuestas', ['model' => $respuestas]) ?>
        <?php endforeach ?>
    </div>

</div>
