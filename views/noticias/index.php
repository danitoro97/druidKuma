<?php

use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\models\NoticiasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Noticias';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/noticias.css');

$ruta = Url::to(['noticias/ajax']);
$js = <<<EOT
var s = document.body.scrollHeight-800;
$(window).scroll(function(){

    if ($(this).scrollTop() > s) {
        console.log('peticionAjax');

        s =1000000;

        $.ajax({
            url: '$ruta',
            type: 'get',
            data: {
                page:$('.noticias').length,
            },
            success : function (data) {

                var h = $('.row').html();
                h += data;
                $('.row').html(h);
                s = document.body.scrollHeight-800;
            },
            error: function (){
                console.log('error');
            }
        })
    }
});
EOT;

$this->registerJs($js);
?>
<div class="noticias-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container">
        <div class="row">
            <?php foreach ($noticias as $noticia):
                echo $this->render('_noticias', ['noticia' => $noticia]);
            endforeach;
            ?>
        </div>
    </div>


</div>
