<?php


use yii\helpers\Url;
use yii\helpers\Html;

$ruta = Url::to(['/equipos-usuarios/eliminar-participante'],true);
$js=<<<EOT

    $('.glyphicon-remove').parent().on('click',function(){
        var div = $(this).closest('.row');
        $.ajax({
            url:'$ruta',
            type:'post',
            data: {
                id:'$model->equipo_id',
                participante_id:'$model->usuario_id'
            },
            success: function(data){
                if (data) {
                    div.remove();
                }
            }
        })
    });
EOT;

$this->registerJs($js);
?>


<div class="row">
    <div class="col-xs-8 text-center">
        <h3><?=Html::encode($model->usuario->nombre)?></h3>
    </div>
    <div class="col-xs-4 ">
        <?php if ($model->equipo->creador_id == Yii::$app->user->identity->id): ?>
            <a href="#">
                <span class="glyphicon glyphicon-remove"></span>
            </a>
        <?php endif;?>
    </div>
</div>
