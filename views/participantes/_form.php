<?php


use yii\helpers\Html;

use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Participantes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participantes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuarios[]')->textInput(['placeholder'=>'Introduce nombre de usuario'])?>

    <div class="form-group">
        <?= Html::submitButton('Invitar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <button id='mas'> Añadir mas participantes</button>
</div>
