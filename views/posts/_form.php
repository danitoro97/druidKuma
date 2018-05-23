<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */
/* @var $form yii\widgets\ActiveForm */


$this->registerJsFile('@web/plugin/fabric.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/dibujo.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugin/jquery-ui.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugin/jquery.dialog.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile('@web/css/jquery-ui.css');

$this->registerCssFile('@web/css/dibujar.css');
$this->registerCssFile('@web/css/jquery.dialog.css');
$this->registerJsFile(
    '@web/plugin/ddslick.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$js = <<<EOT
    $('#imagenes').ddslick({
        onSelected: function(selectedData){
            canvas.clear();
            if (selectedData.selectedData.imageSrc.indexOf('dropbox')>= 0) {
                var p = 'https://dl.dropboxusercontent.com/1/view/hfg2y3aqwvy8znn/Aplicaciones/druidKuma/1.png';
                //https://www.dropbox.com/s/hfg2y3aqwvy8znn/1.png?dl=0
                var p1 = p.substring(0,41);
                var p2 = selectedData.selectedData.imageSrc.substring(26)
                var p3 = p1 + p2;
            }
            else {
                p3 =  selectedData.selectedData.imageSrc;
            }


            fabric.Image.fromURL(p3, function(oImg) {
                canvas.add(oImg);
                canvas.centerObject(oImg);
                oImg.set('selectable', false);
            },{crossOrigin: "Anonymous"});
        },
        imagePosition:"center",
    });

EOT;
$this->registerJs($js);
?>
<div class="posts-form">
    <div class="container">


        <?php $form = ActiveForm::begin([
            'id' => 'posts-form'
        ]); ?>
        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
        <ul>
            <li>Para dibujar figuras selecciona la figura y haz dobleclick en el lienzo</li>
            <li>Para dibujar por libre marca modo libre y presiona click izquierdo mientras te muesves por el lienzo</li>
            <li>Para borrar una figura pulsa sobre ella (con el modo libre desactivado) y pulsa supr</li>
        </ul>
        <div class="row">
            <div class="col-md-2 figura">

            </div>
            <div class="col-md-6">
                <canvas id="myCanvas"></canvas>
            </div>
            <div class="col-md-2 configuracion">

            </div>
        </div>
        <div id="imagenes">
            <select>
                <?php foreach ($imagenes as $imagen) :?>
                    <option value="<?=$imagen->id?>" data-imagesrc="<?=$imagen->ruta?>" crossorigin></option>
                <?php endforeach?>
            </select>
        </div>

        <?= $form->field($model,'canvas')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>


        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
