<?php

namespace app\controllers;

use app\models\Partidos;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PartidosController extends \yii\web\Controller
{
    /**
     * Devuelve los partidos dentro de una fecha.
     * @param  [type] $liga  Liga a la que pertenecen los partidos
     * @param  [type] $start Inicio rango de fecha
     * @param  [type] $end   Fin de rango de fecha
     * @param null|mixed $id
     * @return [type]        Devuelve un array
     */
    public function actionPartidos($liga, $start, $end, $id = null)
    {
        $partidos = Partidos::find()->where(['between', 'fecha', $start, $end])
        ->andWhere(['liga_id' => $liga]);

        if ($id !== null) {
            $partidos = $partidos->andWhere("visitante_id = $id or local_id = $id");
        }
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $eventos = [];
        $now = date('Y-m-d');
        //var_dump($partidos->all());
        //die();
        foreach ($partidos->all() as $partido) {
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


    /**
     * Displays a single Partidos model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('_view', [
           'model' => $this->findModel($id),
        ]);
    }


    /**
     * Finds the Noticias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Partidos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Partidos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
