<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Equipos */

$this->title = $model->nombre;
$this->registerCssFile('/css/equipo.css');
$this->params['breadcrumbs'][] = ['label' => $model->liga->nombre, 'url' => ['/ligas/view','id' => $model->liga_id]];
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
        color: gray;
        pointer-events: none;

    }
    #myCarousel {
        margin-top:100px;
    }
EOT;

$this->registerCss($css);

$this->registerJsFile('plugin/fullcalendar/lib/moment.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('plugin/fullcalendar/fullcalendar.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('plugin/fullcalendar/locale/es.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('plugin/fullcalendar/fullcalendar.min.css');
$this->registerCssFile('css/ventana.css');
$this->registerJsFile('js/ventana.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$ruta = Url::to(['partidos/partidos'], getenv('esquema'));
$js=<<<EOT

    $('#calendar').fullCalendar({
        locale: 'es',
        themeSystem: 'bootstrap3',
        eventSources:[
            {
                url:'$ruta',
                data: {

                    liga:'$model->liga_id',
                    id: '$model->id',
                }
            }

        ],
        defaultView: 'month',
        eventClick: function(event) {

            var y=parseInt((window.screen.height/2)-375);
            var x=parseInt((window.screen.width/2)-500);
           if (event.url) {
             $(this).addClass('visto');
             window.open(event.url,'Partidos',"width=1000,height=750, top="+y+",left="+x);
             return false;
           }
        },
    });
EOT;

$this->registerJs($js);
?>
<div class="equipos-view" itemscope itemtype="http://schema.org/SportsTeam">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 itemprop="name"><?= Html::encode($this->title) ?> <?=Html::encode($model->liga->nombre)?>
                    de <?=Html::encode($model->liga->pais->nombre) ?>
                </h1>
            </div>
        </div>
        <div class="row">
            <?php echo $this->render('/ligas/_clasificacion', ['clasificacion' => $clasificacion, 'equipo' => $model->id]); ?>
            <div class="col-md-4">

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

        </div>


        <div class="row">
            <div class="col-md-12">
                <h2>Proximos partidos</h2>
                <div id="calendar">

                </div>
            </div>
        </div>
    </div>
</div>
