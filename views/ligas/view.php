<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ligas */
/* @var $partidos app\models\Partidos*/

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Ligas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ligas-view">

    <h1><?= Html::encode($this->title) ?> (<?=Html::encode($model->siglas)?>)
         de <?=Html::encode(ucwords(mb_strtolower($model->pais->nombre)))?>

    </h1>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2>Proximos partidos</h2>
            </div>
            <?php echo $this->render('_clasificacion', ['clasificacion' => $clasificacion, 'equipo' => false]); ?>
            
        </div>

        <h2>Ultimos partidos jugados</h2>

        <?=GridView::widget([
            'dataProvider' => $partidos,
            'columns' => [
                'fecha:date',
                'estado',
                'local.nombre',
                'goles_local',
                'visitante.nombre',
                'goles_visitante',
             ],
            ]) ?>
    </div>
</div>
