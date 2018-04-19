<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Participantes */

$this->title = 'Update Participantes: ' . $model->equipo_id;
$this->params['breadcrumbs'][] = ['label' => 'Participantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->equipo_id, 'url' => ['view', 'equipo_id' => $model->equipo_id, 'usuario_id' => $model->usuario_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="participantes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
