<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PlantillaUsuario */

$this->title = 'Añadir imagen a la Plantilla';
$this->params['breadcrumbs'][] = ['label' => 'Mi Plantilla ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plantilla-usuario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
