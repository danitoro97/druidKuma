<?php

use app\models\Usuarios;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <h1><?= Html::encode($title) ?></h1>
                <?php $form = ActiveForm::begin([
                    'id' => 'usuarios-form'
                ]); ?>

                <?= $form->field($model, 'nombre',['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email',['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'password',['enableAjaxValidation' => true])->passwordInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Registrar', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>


</div>
