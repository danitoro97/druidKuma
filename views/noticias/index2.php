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
    console.log(document.body.scrollHeight);
    console.log($(this).scrollTop());
    //var s = document.body.scrollHeight-800;
    if ($(this).scrollTop() > s) {
        console.log('peticionAjax');
        //$(this).off();
        s =1000000;

        $.ajax({
            url: '$ruta',
            type: 'get',
            data: {
                page:$('.noticias').length,
            },
            success : function (data) {
                //console.log(data);
                var h = $('.row').html();
                h += data;
                $('.row').html(h);
                //$(this).on();
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
            //En siguiente iran la vista parcial _noticias con las siguientes noticias
            //Paginacion por ajax?>
            <div class="siguiente">

            </div>
        </div>
    </div>


</div>
