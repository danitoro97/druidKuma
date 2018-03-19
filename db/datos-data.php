<?php

function pdo()
{
    return new PDO('pgsql:host=localhost;dbname=druidkuma', 'druidkuma', 'druidkuma');
}

function conexion($uri)
{

    //$uri = 'http://api.football-data.org/v1/competitions/?season=2017';
    $reqPrefs['http']['method'] = 'GET';
    $reqPrefs['http']['header'] = 'X-Auth-Token: b6bd8f58d2004677a6149e44be9d1a99';

    $stream_context = stream_context_create($reqPrefs);
    $response = file_get_contents($uri, false, $stream_context);
    return json_decode($response);
}

function insertar($dato, $fichero)
{
    $dato[strripos($dato, ',')] = ';';
    //var_dump($insert);

    //$fichero = 'datos.sql';
    // Abre el fichero para obtener el contenido existente
    $actual = file_get_contents($fichero);
    // Añade una nueva persona al fichero
    $actual = $dato;
    // Escribe el contenido al fichero
    file_put_contents($fichero, $actual);
}
