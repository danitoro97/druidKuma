<?php

namespace app\controllers;

use app\models\EquiposUsuarios;
use app\models\Participantes;
use app\models\Plantilla;
use app\models\PlantillaUsuario;
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
                'only' => ['index', 'create', 'view', 'create-publico', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'view', 'create-publico', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lista de todos los posts de un equipo concreto.
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
     * Lista todos los posts publico.
     * @return [type] [description]
     */
    public function actionPublico()
    {
        return $this->render('publico', [
            'model' => Posts::find()
            ->where('equipo_usuario_id is null')
            ->orderBy('created_at DESC')
            ->all(),
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
        $model = $this->findModel($id);
        if (!$this->isParticipante($model->equipo_usuario_id)) {
            Yii::$app->session->setFlash('error', 'This is the message');
            return $this->goBack();
        }

        return $this->render('view', [
            'model' => $model,
            //'equipo' => $this->findEquipo($id),
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
        $model->scenario = Posts::ESCENARIO_EQUIPO;
        return $this->create($model, ['index', 'id' => $id]);
    }

    /**
     * Crea un post publico.
     * @return [type] [description]
     */
    public function actionCreatePublico()
    {
        $model = new Posts();
        $model->creador_id = Yii::$app->user->identity->id;
        return $this->create($model, ['publico']);
    }

    /**
     * Ves un post publico.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionViewPublico($id)
    {
        return $this->render('view-publico', [
            'model' => $this->findModel($id),
            //'equipo' => $this->findEquipo($id),
        ]);
    }

    /**
     * Crea un post.
     * @param  [type] $model [description]
     * @param  [type] $ruta  [description]
     * @return [type]        [description]
     */
    public function create($model, $ruta)
    {
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->upload();
            $model->save();
            return $this->redirect($ruta);
        }
        $imagenes = array_merge(Plantilla::find()->all(), PlantillaUsuario::find()
                                      ->where(['usuario_id' => Yii::$app->user->identity->id])
                                      ->all());

        return $this->render('create', [
                'model' => $model,
                'imagenes' => $imagenes,
            ]);
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @param mixed $ruta
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
    public function actionDelete($id, $ruta)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->identity->id == $model->creador_id) {
            $model->delete();
        }

        return $this->redirect($ruta);
    }

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

        throw new NotFoundHttpException('The requested page does not exist dasds.');
    }

    /**
     * Busca el equipo con ese identificador y lo devuelve si existe.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function findEquipo($id)
    {
        if (($model = EquiposUsuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Comprueba si el usuario es parte del equipo.
     * @param  [type]  $id [description]
     * @return bool     [description]
     */
    public function isParticipante($id)
    {
        return Participantes::find()
                    ->where(['equipo_id' => $id])
                    ->andFilterWhere(['usuario_id' => Yii::$app->user->identity->id])
                    ->andFilterWhere(['aceptar' => true])
                    ->exists();
    }
}
