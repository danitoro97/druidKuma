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
    <?php

    $data = Usuarios::find()->all();
    $data = ArrayHelper::map($data,'id','nombre');


    ?>
    <?= $form->field($model, 'usuario_id')->dropDownList($data, [
        'prompt'=>'- Selecciona un usuario -'
        ])?>
        <button id='mas'> Añadir mas participantes</button>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
