<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EquiposUsuarios */

$this->title = 'Update Equipos Usuarios: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Equipos Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="equipos-usuarios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
