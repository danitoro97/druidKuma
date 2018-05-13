<?php

namespace app\controllers;

use app\models\PlantillaUsuario;
use app\models\Usuarios;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
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
                    'only' => ['create', 'update', 'delete', 'plantilla', 'validar'],
                    'rules' => [
                            [
                                'allow' => true,
                                'actions' => ['create', 'validar'],
                                'roles' => ['?'],
                            ],
                            [
                                'allow' => true,
                                'actions' => ['update', 'delete', 'plantilla'],
                                'roles' => ['@'],
                            ],
                    ],
            ],
        ];
    }

    /**
     * Displays a single Usuarios model.
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

    /**
     * Action que valida a un usuario , validar a un usuario consiste en
     * tener el token_val a null.
     * @param  string $token_val Token de acceso
     * @return [type]            [description]
     */
    public function actionValidar($token_val)
    {
        if ($u = Usuarios::findOne(['token_val' => $token_val])) {
            $u->token_val = null;
            $u->save();
            Yii::$app->user->login($u);
            Yii::$app->session->setFlash('success', 'Usuario validado con exito');
        }
        return $this->goHome();
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios();
        $model->scenario = Usuarios::ESCENARIO_CREAR;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!$model->enviarCorreo()) {
                Yii::$app->session->setFlash('info', 'Ha ocurrido un error al enviar el correo de validacion');
                $model->password = '';
                $model->password_repeat = '';
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            Yii::$app->session->setFlash('info', 'Revise su correo para validar la cuenta');
            return $this->goHome();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionPlantilla()
    {
        return $this->render('plantilla', [
            'model' => PlantillaUsuario::find()->where(['usuario_id' => Yii::$app->user->identity->id])->all(),
        ]);
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = Usuarios::ESCENARIO_ACTUALIZAR;
        $model->password = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Usuario actualizado');
            return $this->goBack();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $usuario = Yii::$app->user->identity;
        $usuario->delete();
        return $this->goHome();
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
