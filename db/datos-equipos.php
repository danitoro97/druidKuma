<?php

require 'datos-data.php';

$pdo = pdo();

$sent = $pdo->prepare('select id from ligas');
$sent->execute();
var_dump($sent);
$insert = 'insert into equipos (nombre,alias,liga_id) values';
foreach ($sent as $liga){
    $id = $liga['id'];
    $url = "http://api.football-data.org/v1/competitions/$id/teams";
    $resultado = conexion($url);
    foreach ($resultado->teams as $equipo) {
        $insert .= "('" .$equipo->name . "','" . $equipo->shortName . "'," . $id . "),";
    }

}

//var_dump($insert);
insertar($insert, 'equipos.sql');

//Si se vuelve a ejecutar recordar quitar 'k' del archivo equipos.sql
