<?php

namespace app\controllers;

use app\components\Clasificacion;
use app\models\Ligas;
use app\models\Partidos;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
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
        $clasificacion = Clasificacion::clasificacion($model->equipos, $id);

        return $this->render('view', [
            'model' => $model,
            'partidos' => new ActiveDataProvider([
                'query' => Partidos::find()->where(['liga_id' => $model->id, 'estado' => 'TERMINADO'])->orderBy('fecha DESC'),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
            'clasificacion' => new ArrayDataProvider([
                'allModels' => $clasificacion,
            ]),
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
