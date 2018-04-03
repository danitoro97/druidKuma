<?php

namespace app\controllers;

use app\components\Clasificacion;
use app\models\Equipos;
use app\models\JugadoresSearch;
use app\models\Ligas;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
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

    /**
     * Displays a single Equipos model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $liga = Ligas::findOne($model->liga_id);
        $clasificacion = Clasificacion::clasificacion($liga->equipos, $model->liga_id);

        $searchModel = new JugadoresSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, $id);


        return $this->render('view', [
            'model' => $model,
            'clasificacion' => new ArrayDataProvider([
                'allModels' => $clasificacion,
            ]),
            'dataProviderJugadores' => $dataProvider,
            'searchModelJugadores' => $searchModel,
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
