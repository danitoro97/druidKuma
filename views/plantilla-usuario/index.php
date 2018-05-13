<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plantilla Usuarios';
$this->params['breadcrumbs'][] = $this->title;
$ruta = Url::to(['plantilla-usuario/delete']);
$js =<<<EOT
$('.glyphicon-remove').on('click',function(event){
       event.preventDefault();
       var id = $(this).data('id');
       var div = $(this).parent().parent();
       $.ajax({
           url:'$ruta',
           type:'post',
           data: {
               id:id,
           },
           success: function (data) {
               if (data) {
                   //si sale bien la peticion
                   div.remove();
               } else {
                   //si no
                   alert('No se ha eliminado la img correctamente');
               }
           }
       });
   });

EOT;
$this->registerJs($js);
$css = <<<EOT
    .plantilla-usuario-index img {
        padding :2px;
    }
EOT;

$this->registerCss($js);
?>
<div class="plantilla-usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Añadir nueva imagen Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php foreach ($model as $img) :?>
        <?=$this->render('_img',['model'=> $img])?>
    <?php endforeach; ?>
</div>
