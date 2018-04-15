<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Equipos */

$this->title = $model->nombre;
$this->registerCssFile('/css/equipo.css');
$this->params['breadcrumbs'][] = ['label' => 'Equipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/carrousel.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$ruta = Url::to(['/equipos/view'], getenv('esquema'));
$js = <<<EOT
    $('#myCarousel').carousel('pause');
    carrousel('$ruta', '$model->id');
EOT;

$this->registerJs($js);
$css = <<<EOT
    a.disabled {
    /* Make the disabled links grayish*/
    color: gray;
    /* And disable the pointer events */
    pointer-events: none;
}
EOT;

$this->registerCss($css);
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
            <div class="col-md-5">

                <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <!-- Indicators -->
                   <ol class="carousel-indicators">
                     <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                     <li data-target="#myCarousel" data-slide-to="1"></li>
                     <li data-target="#myCarousel" data-slide-to="2"></li>

                   </ol>

                   <!-- Wrapper for slides -->
                   <div class="carousel-inner" role="listbox">
                       <?=  $this->render('/jugadores/_carrousel', [
                           'jugadores' => $jugadores
                       ])?>
                   </div>

                   <!-- Left and right controls -->
                   <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                     <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                   </a>
                   <a id='next' class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                     <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                   </a>
               </div>
            </div>
            <?php echo $this->render('/ligas/_clasificacion', ['clasificacion' => $clasificacion, 'equipo' => $model->id]); ?>
        </div>

    </div>
</div>
