<?php

require 'datos-data.php';

$pdo = pdo();

$sent = $pdo->prepare('select id from ligas');
$sent->execute();

$insert = 'insert into equipos (id,nombre,liga_id,url) values';
foreach ($sent as $liga) {
    $id = $liga['id'];
    $url = "http://api.football-data.org/v1/competitions/$id/leagueTable";
    $resultado = conexion($url);
    //var_dump($resultado->standing);
    //die();
    foreach ($resultado->standing as $equipo) {
        //    var_dump($equipo);
        //    die();
        $insert .= '(' . $equipo->teamId . ",'" .
        $equipo->team . "'," . $id . ",'" .
        $equipo->crestURI . "'),";
    }
}

//var_dump($insert);
insertar($insert, 'equipos.sql');

//Si se vuelve a ejecutar recordar quitar 'k' del archivo equipos.sql
