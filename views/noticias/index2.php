<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoticiasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Noticias';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/noticias.css');
?>
<div class="noticias-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container">
        <div class="row">
            <?php foreach ($noticias as $noticia):
                echo $this->render('_noticias', ['noticia' => $noticia]);
            endforeach;
            //En siguiente iran la vista parcial _noticias con las siguientes noticias
            //Paginacion por ajax?>
            <div class="siguiente">

            </div>
        </div>
    </div>


</div>
