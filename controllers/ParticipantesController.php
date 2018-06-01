<?php

namespace app\controllers;

use app\models\EquiposUsuarios;
use app\models\Participantes;
use app\models\Usuarios;
use Yii;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete', 'create', 'aceptar-peticion'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['delete', 'create', 'aceptar-peticion'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Creates a new Participantes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @param mixed $equipoId
     */
    public function actionCreate($equipoId)
    {
        $equipo = EquiposUsuarios::findOne(['id' => $equipoId]);

        if ($equipo == null || $equipo->creador_id != Yii::$app->user->identity->id) {
            //Yii::$app->session->setFlash('error', 'No existe ese equipo');
            return $this->goBack();
        }


        $model = new Participantes();
        $model->equipo_id = $equipo->id;

        if ($model->load(Yii::$app->request->post())) {
            var_dump($model->usuarios);
            //die();

            foreach ($model->usuarios as $usuario) {
                $participante = new Participantes();
                $participante->equipo_id = $equipo->id;
                $user = Usuarios::findOne(['nombre' => $usuario]);

                if ($user != null) {
                    $participante->usuario_id = $user->id;
                    $participante->save();
                }
            }

            return $this->redirect(['/equipos-usuarios/index']);
        }

        return $this->render('create', [
            'model' => $model,
            'equipo' => $equipo,
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

    public function actionAbandonar($id)
    {
        $model = $this->findModel($id, Yii::$app->user->identity->id);

        if ($model->equipo->creador_id == Yii::$app->user->identity->id) {
            Yii::$app->session->setFlash('error', 'No puedes abandonar este equipo');
        } else {
            $model->delete();
        }

        return $this->redirect(['/equipos-usuarios']);
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
