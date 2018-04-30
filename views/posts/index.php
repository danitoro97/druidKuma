<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/equiposUsuarios.css');
?>
<div class="posts-index">
    <div class="col-md-2">
        <div class="row">
            <div class="text-center">
                <h5>Participantes</h5>
            </div>
        </div>
        <?php foreach ($equipo->participantes as $participante) : ?>
            <?= $this->render('_participantes', [
                'model' => $participante
            ])?>
        <?php endforeach ?>
    </div>
    <div class="container col-md-8">
        <div class="row">
            <div class="text-center">
                <h3>Equipo <?= Html::encode($equipo->nombre) ?></h3>

                <p>
                    <?= Html::a('Create Posts', ['create', 'id' => $equipo->id], ['class' => 'btn btn-success']) ?>
                    <?php
                        if ($equipo->creador_id == Yii::$app->user->identity->id) : ?>
                            <?=Html::a('Añadir participantes', ['/participantes/create', 'equipoId' => $equipo->id], ['class' => 'btn btn-info'])?>
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <?php foreach ($model as $post) : ?>
                    <?= $this->render('_post', [
                        'model' => $post
                    ]) ?>
        <?php endforeach ?>

    </div>


</div>
