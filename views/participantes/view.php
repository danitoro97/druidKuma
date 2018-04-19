<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Participantes */

$this->title = $model->equipo_id;
$this->params['breadcrumbs'][] = ['label' => 'Participantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participantes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'equipo_id' => $model->equipo_id, 'usuario_id' => $model->usuario_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'equipo_id' => $model->equipo_id, 'usuario_id' => $model->usuario_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'equipo_id',
            'usuario_id',
            'aceptar:boolean',
        ],
    ]) ?>

</div>
