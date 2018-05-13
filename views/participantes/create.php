<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Participantes */

$this->title = 'Invitar al equipo ' . $equipo->nombre;
$this->params['breadcrumbs'][] = ['label' => $equipo->nombre, 'url' => ['/posts/index','id'=> $equipo->id]];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/participantes.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="participantes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
