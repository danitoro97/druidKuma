<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Foro';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/equiposUsuarios.css');
?>
<div class="posts-index">
        <?=Html::a('crear', ['/posts/crear-publico']) ?>
        <?php foreach ($model as $post) : ?>
                    <?= $this->render('_post', [
                        'model' => $post,
                        'ruta' => ['/posts/view-publico','id' => $post->id]
                    ]) ?>
        <?php endforeach ?>




</div>
