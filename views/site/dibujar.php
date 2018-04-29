<?php

use yii\helpers\Html;


$this->registerJsFile('@web/plugin/fabric.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/dibujo.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugin/jquery-ui.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/css/jquery-ui.css');
$js =<<<EOT

$( function() {
    $( "input" ).checkboxradio();

} );

EOT;
$this->registerJs($js);
?>
<div class="row">
    <div class="col-md-7">
            <canvas id="myCanvas"><?=Html::img('@web/futbolista.png', ['id'=>'futbol'])?></canvas>
    </div>
</div>
