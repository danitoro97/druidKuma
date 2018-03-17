<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model app\models\Noticias */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('/plugin/summernote/summernote.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/plugin/summernote/lang/summernote-es-ES.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/plugin/summernote/summernote-lite.css');
$js=<<<EOT
    $('#noticias-texto').summernote({
        popover: {},
        height: 400,
        lang:'es-ES',
    });
EOT;

$this->registerJs($js,View::POS_READY);
?>

<div class="noticias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'subtitulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'texto')->textarea()?>

    <?= $form->field($model, 'img')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
