<?php

use \yii\helpers\Html;

?>
<div class="col-md-4 text-center">
        <?=Html::img($model->url, ['class' => 'img-responsive'])?>
        <a href="#">
            <span class="glyphicon glyphicon-remove" data-id="<?=$model->id?>">Quitar de la plantilla</span>
        </a>
</div>
