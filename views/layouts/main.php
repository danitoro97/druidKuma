<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
$js = <<<EOT
$('#gotop').gotop({
  customHtml: '<span class="glyphicon glyphicon-menu-up"></span>',

});
EOT;

$this->registerJs($js, View::POS_READY);
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
    $item = [
            ['label' => 'Inicio', 'url' => ['/noticias/index']],
            //['label' => 'Noticias', 'url' => ['/noticias/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']]
        ];

    if (Yii::$app->user->isGuest) {
        $item[] = ['label' => 'Iniciar sesión' , 'url' => ['/site/login']];
    }  else {
        $item[] = [
           'label' => 'Usuarios (' . Yii::$app->user->identity->nombre . ')',
           'items' => [
               ['label' => 'Modificar datos', 'url' => ['usuarios/update']],
               '<li class="divider"></li>',
               [
                   'label' => 'Logout',
                   'url' => ['site/logout'],
                   'linkOptions' => ['data-method' => 'POST'],
               ],
           ]
       ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' =>/* [
            ['label' => 'Inicio', 'url' => ['/noticias/index']],
            //['label' => 'Noticias', 'url' => ['/noticias/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Iniciar sesión', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Cerrar sesión (' . Yii::$app->user->identity->nombre . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],*/
        $item ,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'itemTemplate' => "<li>{link}</li>\n",
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div id="gotop">

        </div>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">DruidKuma <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
