<?php


/* @var $this yii\web\View */
/* @var $model app\models\Posts */
use yii\helpers\Url;


$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Mis Equipos', 'url' => ['/equipos-usuarios/index']];
$this->params['breadcrumbs'][] = ['label' => $model->equipoUsuario->nombre, 'url' => ['/posts/index', 'id' => $model->equipo_usuario_id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?=$this->render('_view', [
    'model' => $model,
    'rutaPadre'=> Url::to(['/respuestas/create-padre']),
    'ruta' => Url::to(['respuestas/create']),
    
])
?>
