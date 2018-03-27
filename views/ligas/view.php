<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ligas */
/* @var $partidos app\models\Partidos*/

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Ligas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('plugin/fullcalendar/lib/moment.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('plugin/fullcalendar/fullcalendar.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('plugin/fullcalendar/locale/es.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('plugin/fullcalendar/fullcalendar.min.css');
$ruta = Url::to(['partidos/partidos'],true);
$js=<<<EOT

    $('#calendar').fullCalendar({
        locale: 'es',
        themeSystem: 'bootstrap3',
        eventSources:[
            {
                url:'$ruta',
                data: {
                    liga:'$model->id',
                }
            }

        ],
        defaultView: 'month',
        navLinks: true,
    });
EOT;

$this->registerJs($js);

?>
<div class="ligas-view">

    <h1><?= Html::encode($this->title) ?> (<?=Html::encode($model->siglas)?>)
         de <?=Html::encode(ucwords(mb_strtolower($model->pais->nombre)))?>

    </h1>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!--<h2>Ultimos partidos jugados</h2>

                <?=GridView::widget([
                    'dataProvider' => $partidos,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '0'],
                    'columns' => [
                        'fecha:date',
                        'local.nombre',
                        'goles_local',
                        'visitante.nombre',
                        'goles_visitante',
                     ],
                    ]) ?>
                !-->
            </div>
            <?php echo $this->render('_clasificacion', ['clasificacion' => $clasificacion, 'equipo' => false]); ?>

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
