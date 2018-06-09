<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Ligas;
use app\widgets\Alert;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
$ruta = Url::to(['/equipos/equipos']);
$foro = Url::to(['/posts/publico']);
$crear = Url::to(['/posts/create-publico']);
$home = Url::to(['/noticias/index']);
$js = <<<EOT

    var options = {
        url: "$ruta",

        getValue: "label",

        template: {
            type: "links",
            fields: {
                link: "value"
            }
        },

        list: {
    		/*onClickEvent: function(event) {
    			enlace = $("#search").getSelectedItemData().value;
                window.location.href = enlace;
    		},*/
            match: {
                enabled: true
            },
            sort: {
                enabled: true
            }
	    },

        ajaxSettings: {
            dataType: "json",
            method: "GET",
            data: {
              busqueda: $(this).val()
            }
        },

        theme: "round"
    };

$("#search").easyAutocomplete(options);

if ('serviceWorker' in navigator) { // Comprobando si el servicio esta disponible en el navegador
        
            navigator.serviceWorker.register('/js/sw-fallback.js').then(function (registration) {

        }).catch(function (err) {
            console.log('ServiceWorker registration failed: ', err);
        });

}

$(document).on('keypress',function(event){
        var x = event.which || event.keyCode;
        var codes = [122,26,28,60,44,12];
        var arrayRutas = ['$foro','$foro','$crear','$crear','$home','$home'];

        if (event.ctrlKey) {
            console.log(x);
            var pos = codes.indexOf(x);
            console.log(pos)
            if (pos >= 0) {
                event.preventDefault();
                window.location.href = arrayRutas[pos];
            }
        }

    });

EOT;

$this->registerJs($js);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $ligas = Ligas::find()->all();
    $i = [];
    foreach ($ligas as $liga) {

        $i[] = [
            'label' => $liga->nombre,
            'url' => ['/ligas/view', 'id' => $liga->id],
        ];


    }
    echo "<form class='navbar-form navbar-right'>
       <div class='form-group has-feedback'>
            <input id='search' type='text' placeholder='Buscar equipo' class='form-control'>
        </div>
    </form>";
    $item = [
            ['label' => 'Inicio', 'url' => ['/noticias/index']],
            ['label' => 'Ligas', 'items' => $i],
            ['label' => 'Foro' , 'url' => ['/posts/publico']],
    ];

    if (Yii::$app->user->isGuest) {

        $item[] = ['label' => 'Iniciar sesión' , 'url' => ['/site/login']];
    }  else {
        $item[] = ['label' => 'Mis Equipos', 'url' => ['/equipos-usuarios/index']];
        $item[] = [
           'label' => 'Usuarios (' . Yii::$app->user->identity->nombre . ')',
           'items' => [
               ['label' => 'Mi perfil', 'url' => ['usuarios/view', 'id' => Yii::$app->user->identity->id]],
               '<li class="divider"></li>',
               ['label' => 'Ver plantilla imagenes', 'url' => ['/plantilla-usuario']],
               '<li class="divider"></li>',
               [
                   'label' => 'Logout',
                   'url' => ['site/logout'],
                   'linkOptions' => ['data-method' => 'POST'],
               ],
               '<li class="divider"></li>',
               [
                   'label' => 'Darse de baja',
                   'url' => ['usuarios/delete'],
                   'linkOptions' => ['data-method' => 'POST'],
               ],
           ]
       ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' =>$item ,
    ]);
    NavBar::end();
    ?>
    <div id="gotop">

    </div>
    <div class="container">
        <?= Breadcrumbs::widget([
            'itemTemplate' => "<li>{link}</li>\n",
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
                <div class="col-md-2 col-sm-4 col-xs-6">

                    <p class="">DruidKuma <?= date('Y') ?></p>


                </div>
                <div class="col-md-2 col-sm-4 col-xs-6">
                    <p class=""><?= Yii::powered() ?></p>
                </div>
                <div class="col-md-2 col-md-offset-5 col-sm-4 col-xs-6">
                    <p>
                        <?=Html::a('<span>Notificar un error</span>',['/site/notificar'])?>
                    </p>
                    <p>
                        <?=Html::a('<span>Lista de atajos</span>',['/site/atajos'])?>
                    </p>
                </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
