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
        s =1000000;

        $.ajax({
            url: '$ruta',
            type: 'get',
            data: {
                page:$('.noticias').length,
            },
            success : function (data) {
                $('#noticias').append(data);
                s = document.body.scrollHeight-800;
            },
            error: function (){
                console.log('error');
            }
        })
    }
});

$('.up').on('click',function(e){
    e.preventDefault();
    var ancla = '#top';
    $('body,html').stop(true,true).animate({
        scrollTop: $(ancla).offset().top
    },1000);
});
EOT;

$this->registerJs($js);
?>
<div class="noticias-index" id="noticias">

    <h1 id='top'><?= Html::encode($this->title) ?></h1>
    <?php
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isCreador()):?>
            <?=Html::a('Crear noticia', ['noticias/create'], ['class' => 'btn-lg btn-info crear'])?>
    <?php endif;?>
    <div class="container">
        <div class="row">

            <?php foreach ($noticias as $noticia):
                echo $this->render('_noticias', ['noticia' => $noticia]);
            endforeach;
            ?>
        </div>
    </div>

    <a href="#top"><?=Html::img('up.png', ['class' => 'up'])?></a>
</div>
