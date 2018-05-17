<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = 'Crear Posts';
$this->params['breadcrumbs'][] = ['label' => 'Mis Equipos', 'url' => ['/equipos-usuarios/index']];
$this->params['breadcrumbs'][] = ['label' => $equipo->nombre, 'url' => ['index', 'id' => $equipo->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'imagenes' => $imagenes
    ]) ?>

</div>
