<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use  froala\froalaeditor\FroalaEditorWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Noticias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="noticias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'subtitulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'texto')->widget(FroalaEditorWidget::className(), [
        'clientOptions'=>[
            'toolbarInline'=> false,
            'theme' =>'gray',//optional: dark, red, gray, royal
            'language'=>'es' // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
        ]
       ]) ?>

    <?= $form->field($model, 'img')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
