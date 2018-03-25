<?php

namespace app\components;

use app\models\Partidos;

class Clasificacion
{
    /**
     * Metodo que recoge los equipos da una liga y te crea la clasificacion.
     * @param  [type] $equipos Todos los equipos de una liga
     * @param  int $liga_id Identificador de la liga
     * @return array          Array ordenado de equipos y sus estadisticas
     */
    public static function clasificacion($equipos, $liga_id)
    {
        $clasificacion = [];
        foreach ($equipos as $equipo) {
            // code...

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
                'liga_id' => $liga_id,
            ];
        }

        usort($clasificacion, function ($a, $b) {
            if ($a['pts'] == $b['pts']) {
                $ida = Partidos::find()->where(['local_id' => $a['id'], 'visitante_id' => $b['id'], 'liga_id' => $a['liga_id']])->one();
                $vuelta = Partidos::find()->where(['visitante_id' => $a['id'], 'local_id' => $b['id'], 'liga_id' => $a['liga_id']])->one();

                $golesA = $ida->goles_local + $vuelta->goles_visitante;
                $golesB = $ida->goles_visitante + $vuelta->goles_local;
                if ($golesA == $golesB) {
                    if ($vuelta->goles_visitante == $ida->goles_visitante) {
                        return ($a['gf'] >= $b['gf']) ? -1 : 1;
                    }
                    return ($vuelta->goles_visitante > $ida->goles_visitante) ? -1 : 1;
                }
                return ($golesA > $golesB) ? -1 : 1;
            }
            return ($a['pts'] > $b['pts']) ? -1 : 1;
        });

        return $clasificacion;
    }
}
