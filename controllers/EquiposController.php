<?php

namespace app\controllers;

use app\components\Clasificacion;
use app\models\Equipos;
use app\models\Jugadores;
use app\models\Ligas;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EquiposController implements the CRUD actions for Equipos model.
 */
class EquiposController extends Controller
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
     * Lists all Equipos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Equipos::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEquipos($busqueda)
    {
        //if (Yii::$app->request->isAjax) {
        $equipos = Equipos::find()->where(['ilike', 'nombre', '%' . $busqueda . '%']);
        return $equipos->all();
        //}
    }

    /**
     * Muestra el equipo y sus jugadores. Si la peticion es ajax te devolvera
     * los jugadores que toquen.
     * @param  [type]  $id     [description]
     * @param  int $numero [description]
     * @return [type]          [description]
     */
    public function actionView($id, $numero = 0)
    {
        $model = $this->findModel($id);
        $liga = Ligas::findOne($model->liga_id);
        $clasificacion = Clasificacion::clasificacion($liga->equipos, $model->liga_id);

        $jugadores = Jugadores::find()
        ->where(['equipo_id' => $id])
        ->orderBy('posicion_id,nombre ASC')
        ->offset($numero)
        ->limit(Jugadores::CARROUSEL)
        ->all();


        if (Yii::$app->request->isAjax) {
            //la vista
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return array_merge($jugadores, [
                'url' => Url::to('@web/futbolista.png', true),
                'length' => Jugadores::CARROUSEL,
            ]);
        }


        return $this->render('view', [
            'model' => $model,
            'clasificacion' => new ArrayDataProvider([
                'allModels' => $clasificacion,
            ]),
            'jugadores' => $jugadores,
        ]);
    }

    /**
     * Finds the Equipos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Equipos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Equipos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
