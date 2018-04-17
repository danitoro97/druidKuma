<?php

namespace app\controllers;

use Yii;
use app\models\Participantes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
     * @param integer $equipo_id
     * @param integer $usuario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($equipo_id, $usuario_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($equipo_id, $usuario_id),
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
     * @param integer $equipo_id
     * @param integer $usuario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($equipo_id, $usuario_id)
    {
        $model = $this->findModel($equipo_id, $usuario_id);

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
     * @param integer $equipo_id
     * @param integer $usuario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($equipo_id, $usuario_id)
    {
        $this->findModel($equipo_id, $usuario_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Participantes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $equipo_id
     * @param integer $usuario_id
     * @return Participantes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($equipo_id, $usuario_id)
    {
        if (($model = Participantes::findOne(['equipo_id' => $equipo_id, 'usuario_id' => $usuario_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
