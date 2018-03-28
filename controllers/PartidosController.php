<?php

namespace app\controllers;

use app\models\Partidos;
use yii\helpers\Url;
use yii\web\Response;

class PartidosController extends \yii\web\Controller
{
    /**
     * Devuelve los partidos dentro de una fecha.
     * @param  [type] $liga  Liga a la que pertenecen los partidos
     * @param  [type] $start Inicio rango de fecha
     * @param  [type] $end   Fin de rango de fecha
     * @return [type]        Devuelve un array
     */
    public function actionPartidos($liga, $start, $end)
    {
        $partidos = Partidos::find()->where(['between', 'fecha', $start, $end])
        ->andWhere(['liga_id' => $liga])
        ->all();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $eventos = [];
        $now = date('Y-m-d');

        foreach ($partidos as $partido) {
            $a = ' - ';
            if ($now > $partido->fecha) {
                $p = $partido->goles_local ?? '0';
                $p2 = $partido->goles_visitante ?? '0';
                $a = ' ' . $p . ' - ' . $p2 . ' ';
            }
            $eventos[] = [
                'title' => $partido->local->nombre .
                $a .
                $partido->visitante->nombre,
                'start' => $partido->fecha,
                'url' => Url::to(['partidos/view', 'id' => $partido->id], true),
            ];
        }
        return $eventos;
    }
}
