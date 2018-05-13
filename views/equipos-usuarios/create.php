<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EquiposUsuarios */

$this->title = 'Crer Equipo';
$this->params['breadcrumbs'][] = ['label' => 'Mis Equipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipos-usuarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
