<?php

require 'datos-data.php';

$pdo = pdo();
//$url = 'http://api.football-data.org/v1/teams/66/players';
//$resultado = conexion($url);
//var_dump($resultado->players);


$sent = $pdo->prepare('select id from equipos');
$sent->execute();
var_dump($sent);
$insert = 'insert into jugadores (nombre,posicion_id,dorsal,contrato,equipo_id) values';
foreach ($sent as $liga) {
    $id = $liga['id'];
    $url = "http://api.football-data.org/v1/teams/$id/players";
    $resultado = conexion($url);
    //var_dump($resultado);
    //die();
    foreach ($resultado->players as $jugador) {
        //var_dump($jugador);
        //die();
        $insert .= "('" . $jugador->name . "'," .
            rand(0, 3) . ',' .
            $jugador->jerseyNumber . ",'" .
            ($jugador->contractUntil) ? $jugador->contractUntil : '' . "'," .
            $id . '),';
    }
}

var_dump($insert);
insertar($insert, 'jugadores.sql');
