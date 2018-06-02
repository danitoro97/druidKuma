<?php



use yii\helpers\Html;

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
