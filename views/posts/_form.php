<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */
/* @var $form yii\widgets\ActiveForm */


$this->registerJsFile('@web/plugin/fabric.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/dibujo.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugin/jquery-ui.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/css/jquery-ui.css');
$this->registerCssFile('@web/css/dibujar.css');
$this->registerJsFile(
    '@web/plugin/ddslick.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$js = <<<EOT
    $('#imagenes').ddslick({
        onSelected: function(selectedData){
            canvas.clear();
            fabric.Image.fromURL(selectedData.selectedData.imageSrc, function(oImg) {
                canvas.add(oImg);
                canvas.centerObject(oImg);
                oImg.set('selectable', false);
            });
        },
        imagePosition:"center",
    });
EOT;
$this->registerJs($js);
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin([
        'id' => 'posts-form'
    ]); ?>
    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

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
                <option value="<?=$imagen->id?>" data-imagesrc="<?=$imagen->ruta?>"></option>
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
