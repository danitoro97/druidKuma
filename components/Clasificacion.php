<?php

namespace app\components;

use app\models\Partidos;

class Clasificacion
{
    /**
     * Metodo que recoge los equipos da una liga y te crea la clasificacion.
     * @param  [type] $equipos Todos los equipos de una liga
     * @param  int $ligaId Identificador de la liga
     * @return array          Array ordenado de equipos y sus estadisticas
     */
    public static function clasificacion($equipos, $ligaId)
    {
        $clasificacion = [];

        foreach ($equipos as $equipo) {
            $clasificacion[] = [
                'pj' => $equipo->partidosJugados,
                'pg' => $equipo->victorias,
                'pe' => $equipo->empates,
                'pp' => $equipo->derrotas,
                'gf' => $equipo->golesFavor,
                'gc' => $equipo->golesContra,
                'dif' => $equipo->diff,
                'pts' => $equipo->puntos,
                'nombre' => $equipo->nombre,
                'id' => $equipo->id,
                'liga_id' => $ligaId,
                'url' => $equipo->url,
            ];
        }

        usort($clasificacion, function ($local, $visitante) {
            if ($local['pts'] == $visitante['pts']) {
                $ida = Partidos::find()->where(['local_id' => $local['id'], 'visitante_id' => $visitante['id'], 'liga_id' => $local['liga_id']])->one();
                $vuelta = Partidos::find()->where(['visitante_id' => $local['id'], 'local_id' => $visitante['id'], 'liga_id' => $local['liga_id']])->one();

                $golesA = $ida->goles_local + $vuelta->goles_visitante;
                $golesB = $ida->goles_visitante + $vuelta->goles_local;

                $orden = ($golesA > $golesB) ? -1 : 1;
                if ($golesA == $golesB) {
                    if ($vuelta->goles_visitante == $ida->goles_visitante) {
                        $orden = ($local['gf'] >= $visitante['gf']) ? -1 : 1;
                    }
                    $orden = ($vuelta->goles_visitante > $ida->goles_visitante) ? -1 : 1;
                }
                return $orden;
            }
            return ($local['pts'] > $visitante['pts']) ? -1 : 1;
        });

        return $clasificacion;
    }
}
