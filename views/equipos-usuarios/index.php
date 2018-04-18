<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Equipos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipos-usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

        if ($model == null) {
            echo $this->render('_guia');
        }
    ?>

    <h2>Mis equipos</h2>
    <?php foreach ($model as $m) : ?>
        <?= DetailView::widget([
            'model' => $m,
            'attributes' => [
                'nombre'
            ]
        ]) ?>
    <?php endforeach; ?>

</div>
