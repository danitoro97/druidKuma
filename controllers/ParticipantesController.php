<?php

namespace app\controllers;

use app\models\Participantes;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ParticipantesController implements the CRUD actions for Participantes model.
 */
class ParticipantesController extends Controller
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
     * Lists all Participantes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Participantes::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Participantes model.
     * @param int $equipoId
     * @param int $usuarioId
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($equipoId, $usuarioId)
    {
        return $this->render('view', [
            'model' => $this->findModel($equipoId, $usuarioId),
        ]);
    }

    /**
     * Creates a new Participantes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Participantes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'equipo_id' => $model->equipo_id, 'usuario_id' => $model->usuario_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Participantes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $equipoId
     * @param int $usuarioId
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($equipoId, $usuarioId)
    {
        $model = $this->findModel($equipoId, $usuarioId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'equipo_id' => $model->equipo_id, 'usuario_id' => $model->usuario_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Participantes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $equipoId = Yii::$app->request->post('equipo_id');
            return $this->findModel($equipoId, Yii::$app->user->identity->id)->delete();
        }
    }

    /**
     * Action para poder entrar en un equipò.
     * @return [type]            [description]
     */
    public function actionAceptarPeticion()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $equipoId = Yii::$app->request->post('equipo_id');
            $model = $this->findModel($equipoId, Yii::$app->user->identity->id);
            $model->aceptar = true;
            if ($model->save()) {
                return $this->renderPartial('/equipos-usuarios/_equiposDisponibles', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Finds the Participantes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $equipoId
     * @param int $usuarioId
     * @return Participantes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($equipoId, $usuarioId)
    {
        if (($model = Participantes::findOne(['equipo_id' => $equipoId, 'usuario_id' => $usuarioId])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
