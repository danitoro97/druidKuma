<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Foro';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/equiposUsuarios.css');
?>
<div class="posts-index">


    <?=Html::a('Crear post', ['/posts/create-publico'], ['class' => 'btn btn-success']) ?>

    <div class="container col-md-8 col-md-offset-1">
        <div class="row">
            <?php foreach ($model as $post) : ?>
                        <?= $this->render('_post', [
                            'model' => $post,
                            'ruta' => ['/posts/view-publico','id' => $post->id]
                        ]) ?>
            <?php endforeach ?>
        </div>
    </div>





</div>
