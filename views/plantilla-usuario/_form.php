<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PlantillaUsuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plantilla-usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'img')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
