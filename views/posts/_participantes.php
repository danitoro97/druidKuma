<?php


use yii\helpers\Url;
use yii\helpers\Html;

$ruta = Url::to(['/equipos-usuarios/eliminar-participante'],true);
$id = $model->usuario->id;
$js=<<<EOT

    $('.glyphicon-remove').parent().on('click',function(){
        var div = $(this).closest('.row');
        var id = $(this).data('id');
        
        $.ajax({
            url:'$ruta',
            type:'post',
            data: {
                id:'$model->equipo_id',
                participante_id:id,
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
        <p><?=Html::encode($model->usuario->nombre)?></p>
    </div>
    <div class="col-xs-4">
        <?php if ($model->equipo->creador_id == Yii::$app->user->identity->id && $model->usuario_id != Yii::$app->user->identity->id): ?>
            <a href="#" data-id="<?=$model->usuario_id?>">
                <span class="glyphicon glyphicon-remove"></span>
            </a>
        <?php endif;?>
    </div>
</div>
