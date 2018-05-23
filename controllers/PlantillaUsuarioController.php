<?php

namespace app\controllers;

use app\models\PlantillaUsuario;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * PlantillaUsuarioController implements the CRUD actions for PlantillaUsuario model.
 */
class PlantillaUsuarioController extends Controller
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
                    'only' => ['create', 'delete', 'index'],
                    'rules' => [
                            [
                                'allow' => true,
                                'actions' => ['index', 'delete', 'create'],
                                'roles' => ['@'],
                            ],
                    ],
            ],
        ];
    }

    /**
     * Lists all PlantillaUsuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => PlantillaUsuario::find()->where(['usuario_id' => Yii::$app->user->identity->id])->all(),
        ]);
    }



    /**
     * Creates a new PlantillaUsuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlantillaUsuario();

        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->usuario_id = Yii::$app->user->identity->id;
            $model->upload();

            $model->save();

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing PlantillaUsuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $model = PlantillaUsuario::findOne(Yii::$app->request->post('id'));
            if ($model->usuario_id == Yii::$app->user->identity->id) {
                return $model->delete();
            }
        }
    }

    /**
     * Finds the PlantillaUsuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return PlantillaUsuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlantillaUsuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
