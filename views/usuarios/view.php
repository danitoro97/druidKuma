<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-view">
    <?php

    $actualizar = null;
    if (!Yii::$app->user->isGuest && $model->id == Yii::$app->user->identity->id) {
        $actualizar = Html::a('Modificar datos',['usuarios/update']);
    }


    ?>


    <?= DetailView::widget([
        'model'=>$model,
        //'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'enableEditMode' => false,
        'hideIfEmpty' => true,
        'panel'=>[
            'heading'=>'Usuario ' . ucwords($model->nombre) . ' - '.$actualizar,
            'type'=>DetailView::TYPE_PRIMARY,
            'buttonContainer' => [],
        ],
        'attributes'=>[
            'nombre',
            'email:email',
            ['attribute' => 'role', 'value' => $model->role->nombre],
            ['attribute' => 'created_at', 'value' => Yii::$app->formatter->asDatetime($model->created_at)],
            ['attribute' => 'updated_at', 'value' => Yii::$app->formatter->asDatetime($model->updated_at), 'format' => 'html'],

        ]
    ]); ?>

</div>
