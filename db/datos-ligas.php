<?php

require 'datos-data.php';

$uri = 'http://api.football-data.org/v1/competitions/?season=2017';

$resultado = conexion($uri);
//var_dump($resultado);
$contador = 0;
$paises = [1, 2, 2, 2, 2, 3];
$insert = 'insert into ligas (id,nombre,pais_id,siglas) values';
foreach ($resultado as $dato) {
    //echo $dato->caption;
    //echo $dato->league;
    if ($contador > 3) {
        break;
    }
    $insert .= "('" . $dato->id . "','" . $dato->caption . "','" . $paises[$contador] . "','" . $dato->league . "'),";
    $contador++;
}


insertar($insert, 'ligas.sql');
