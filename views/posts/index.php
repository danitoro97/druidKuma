<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/equiposUsuarios.css');
?>
<div class="posts-index">
    <div class="container col-md-8 col-md-offset-2">
        <div class="row">
            <div class="text-center">
                <h3>Posts <?= Html::encode($model[0]->equipoUsuario->nombre) ?></h3>

                <p>
                    <?= Html::a('Create Posts', ['create'], ['class' => 'btn btn-success']) ?>
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
