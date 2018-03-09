<?php

use yii\helpers\Html;

?>
<h3>Bienvenido a DruidKuma</h3>
use yii\helpers\Html;
<p>
    Hola,

<?=Html::a(Html::encode('Activar cuenta'), ['usuarios/validar', 'token_val' => $token_val])?>

Gracias,

DruidKuma
</p>
