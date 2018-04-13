<?php

namespace app\controllers;

use app\models\Jugadores;
use app\models\JugadoresSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * JugadoresController implements the CRUD actions for Jugadores model.
 */
class JugadoresController extends Controller
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
     * Lists all Jugadores models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JugadoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jugadores model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCarrousel($numero, $equipo_id)
    {
        if (Yii::$app->request->isAjax) {
            $jugadores = Jugadores::find()
                        ->where(['equipo_id' => $equipo_id])
                        ->offset($numero)
                        ->limit(Jugadores::CARROUSEL);
        }
    }

    /**
     * Finds the Jugadores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Jugadores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jugadores::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
