<?php

namespace app\controllers;

use app\models\EquiposUsuarios;
use app\models\Participantes;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EquiposUsuariosController implements the CRUD actions for EquiposUsuarios model.
 */
class EquiposUsuariosController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'eliminar-participante', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'eliminar-participante', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all EquiposUsuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => Participantes::find()
            ->where(['usuario_id' => Yii::$app->user->identity->id])
            ->all(),
        ]);
    }

    /**
     * Creates a new EquiposUsuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EquiposUsuarios();
        $model->creador_id = Yii::$app->user->identity->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return Yii::$app->runAction('/equipos-usuarios/index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Action para eliminar a un participante de un equipo.
     * @return [type] [description]
     */
    public function actionEliminarParticipante()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');

            $model = $this->findModel($id);

            if (Yii::$app->user->identity->id == $model->creador_id) {
                $participanteId = Yii::$app->request->post('participante_id');
                if ($participanteId == $model->creador_id) {
                    return false;
                }
                $modelP = Participantes::find()->where(['equipo_id' => $id])
                ->andWhere(['usuario_id' => $participanteId])->one();
                return $modelP->delete();
            }
            return false;
        }
    }

    /**
     * Deletes an existing EquiposUsuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @param mixed $id
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->creador_id == Yii::$app->user->identity->id) {
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Equipo eliminado correctamente');
            }
        } else {
            Yii::$app->session->setFlash('error', 'No puedes eliminar este equipo');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the EquiposUsuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return EquiposUsuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EquiposUsuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
