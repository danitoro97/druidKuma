<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EquiposUsuarios */

$this->title = 'Create Equipos Usuarios';
$this->params['breadcrumbs'][] = ['label' => 'Equipos Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipos-usuarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
