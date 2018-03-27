<?php

namespace app\controllers;

use app\components\Calendar;
use app\models\Partidos;
use yii\web\Response;

class PartidosController extends \yii\web\Controller
{
    /**
     * Devuelve los partidos dentro de una fecha.
     * @param  [type] $liga  Liga a la que pertenecen los partidos
     * @param  [type] $start Inicio rango de fecha
     * @param  [type] $end   Fin de rango de fecha
     * @param  [type] $_     [description]
     * @return [type]        Devuelve un array
     */
    public function actionPartidos($liga, $start, $end, $_ = null)
    {
        $partidos = Partidos::find()->where(['between', 'fecha', $start, $end])
        ->andWhere(['liga_id' => $liga])
        ->all();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $b = [];

        foreach ($partidos as $partido) {
            // code...

            $a = new Calendar([
                'title' => $partido->local->nombre . '-' . $partido->visitante->nombre,
                'start' => $partido->fecha, ]);
            $b[] = $a->toArray();
        }
        return $b;
    }
}
