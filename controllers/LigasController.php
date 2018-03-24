<?php

namespace app\controllers;

use app\models\Ligas;
use app\models\Partidos;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LigasController implements the CRUD actions for Ligas model.
 */
class LigasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ligas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Ligas::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ligas model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $clasificacion = [];
        foreach ($model->equipos as $equipo) {
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
            ];
        }
        //$clasificacion = ArrayHelper::index($clasificacion, 'pts');
        //arsort($clasificacion);
        usort($clasificacion, function ($a, $b) {
            $ida = Partidos::find()->where(['local_id' => $a['id'], 'visitante_id' => $b['id']]);
            var_dump($ida);
            die();
            if ($a['pts'] == $b['pts']) {
                if ($a['gf'] > $b['gf']) {
                    return -1;
                }
                return 1;
            }
            return ($a['pts'] > $b['pts']) ? -1 : 1;
        });
        print_r($clasificacion);
        die();
        return $this->render('view', [
            'model' => $model,
            'partidos' => new ActiveDataProvider([
                'query' => Partidos::find()->where(['liga_id' => $model->id])->orderBy('fecha DESC'),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
            /*'partidos' => new ArrayDataProvider([
                'allModels' => $model->getPartidos()->orderBy('fecha DESC')->limit(10)->all(),
            ]),*/
        ]);
    }

    /**
     * Finds the Ligas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Ligas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ligas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
