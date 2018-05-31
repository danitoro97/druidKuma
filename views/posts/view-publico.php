<?php

/* @var $this yii\web\View */
/* @var $model app\models\Posts */
use yii\helpers\Url;


$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Foros', 'url' => ['/posts/publico']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=$this->render('_view', [
    'model' => $model,
    'rutaPadre'=> Url::to(['/respuestas/create-padre-foro']),
    'ruta' => Url::to(['respuestas/create-publico']),
    'rutaIndex' => Url::to(['/posts/publico']),
])
?>
