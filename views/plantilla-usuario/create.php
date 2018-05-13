<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PlantillaUsuario */

$this->title = 'Create Plantilla Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Plantilla Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plantilla-usuario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
