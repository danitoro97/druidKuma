<?php

use app\models\Usuarios;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Participantes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participantes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuarios[]')->textInput()?>

    <div class="form-group">
        <?= Html::submitButton('Invitar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <button id='mas'> Añadir mas participantes</button>
</div>
