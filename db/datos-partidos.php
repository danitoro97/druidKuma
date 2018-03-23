<?php

require 'datos-data.php';

$pdo = pdo();
//$url = 'http://api.football-data.org/v1/teams/66/players';
//$resultado = conexion($url);
//var_dump($resultado->players);


$sent = $pdo->prepare('select id from ligas');
$sent->execute();

$insert = 'insert into partidos (fecha,local_id,visitante_id,estado,goles_local,goles_visitante) values';
foreach ($sent as $liga) {
    $id = $liga['id'];
    $url = "http://api.football-data.org/v1/competitions/$id/fixtures";
    $resultado = conexion($url);
    //var_dump($resultado);
    //die();
    foreach ($resultado->fixtures as $partido) {
        //var_dump($jugador);
        //var_dump($jugador->result->goalsHomeTeam);
        //die();
        $insert .= "('" . $partido->date . "'," .
        $partido->homeTeamId . ',' .
        $partido->awayTeamId . ",'" .
        $partido->status . "',";
        $insert .= ($partido->result->goalsHomeTeam) ? $partido->result->goalsHomeTeam . ',' : 'null,';
        $insert .= ($partido->result->goalsAwayTeam) ? $partido->result->goalsAwayTeam . '),' : 'null),';
        //var_dump($insert);
        //die();
    }
}

var_dump($insert);
insertar($insert, 'partidos.sql');
