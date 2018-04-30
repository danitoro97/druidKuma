<?php

namespace app\controllers;

use app\models\EquiposUsuarios;
use app\models\Participantes;
use app\models\Posts;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostsController extends Controller
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
                'only' => ['index', 'create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Posts models.
     * @return mixed
     * @param mixed $id Representa el identificador del equipo
     */
    public function actionIndex($id)
    {
        if (!$this->isParticipante($id)) {
            return $this->goBack();
        }

        return $this->render('index', [
            'model' => Posts::find()->where(['equipo_usuario_id' => $id])->all(),
            'equipo' => $this->findEquipo($id),
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param mixed $id Representa el identificador del equipo
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!$this->isParticipante($id)) {
            return $this->goBack();
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'equipo' => $this->findEquipo($id),
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @param mixed $id Representa el identificador del equipo
     */
    public function actionCreate($id)
    {
        if (!$this->isParticipante($id)) {
            return $this->goBack();
        }

        $model = new Posts();
        $model->creador_id = Yii::$app->user->identity->id;
        $model->equipo_usuario_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->upload();
            $model->save();
            return $this->redirect(['index', 'id' => $id]);
        }

        return $this->render('create', [
            'model' => $model,
            'equipo' => $this->findEquipo($id),
        ]);
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }*/

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
*/
    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function findEquipo($id)
    {
        if (($model = EquiposUsuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function isParticipante($id)
    {
        return Participantes::find()
                    ->where(['equipo_id' => $id])
                    ->andFilterWhere(['usuario_id' => Yii::$app->user->identity->id])
                    ->andFilterWhere(['aceptar' => true])
                    ->exists();
    }
}
