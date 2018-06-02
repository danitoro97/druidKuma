<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/login.css');
?>
<div class="site-login">

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-3">
                <fieldset>
                    <legend><?= Html::encode($this->title) ?></legend>
                </fieldset>

                <?=Html::a('¿No tienes cuenta ? Create una ', ['usuarios/create'])?>
                
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',

                ]); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ]) ?>

                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                            <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>
    </div>




</div>
