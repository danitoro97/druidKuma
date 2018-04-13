<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Equipos */

$this->title = $model->nombre;
$this->registerCssFile('/css/equipo.css');
$this->params['breadcrumbs'][] = ['label' => 'Equipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/carrousel.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="equipos-view">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?= Html::encode($this->title) ?> <?=Html::encode($model->liga->nombre)?>
                    de <?=Html::encode($model->liga->pais->nombre) ?>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                <?=Html::img($model->url, ['class' => 'img-equipo'])?>
            </div>
            <?php echo $this->render('/ligas/_clasificacion', ['clasificacion' => $clasificacion, 'equipo' => $model->id]); ?>
        </div>
    </div>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner">
          <?= $this->render('/jugadores/_carrousel', [
              'jugadores' => $jugadores,
              'contador' => 0,
          ]) ?>

      </div>

      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a id='next' class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
  </div>

</div>
