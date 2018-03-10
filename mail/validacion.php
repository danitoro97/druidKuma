<?php

use yii\helpers\Url;

?>
<h3>Hola, bienvenido a DruidKuma</h3>

<p>
    Haz click en el siguiente enlace para validar su cuenta

<?=Url::to(['usuarios/validar', 'token_val' => $token_val], true)?>

Gracias,

DruidKuma
</p>
