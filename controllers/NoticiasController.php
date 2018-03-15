<?php

namespace app\controllers;

use app\models\Noticias;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * NoticiasController implements the CRUD actions for Noticias model.
 */
class NoticiasController extends Controller
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
                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'matchCallback' => function ($rule, $action) {
                            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isCreador()) {
                                return true;
                            }
                            Yii::$app->session->setFlash('error', 'Usted no puede crear noticias');
                            return false;
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Noticias models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'noticias' => Noticias::find()
                    ->select('noticias.id ,titulo, img, subtitulo,creador_id, noticias.created_at')
                    ->joinWith('creador')
                    ->orderBy(['created_at' => SORT_DESC])
                    ->limit(Noticias::PAGESIZE)
                    ->offset(0)
                    ->all(),
        ]);
    }
    /**
     * Devulve lista de noticias.
     * @param  [type] $page Numero de noticias ya mostradas
     * @return [type]       Devulve una vista parcial
     */
    public function actionAjax($page)
    {
        $model = Noticias::find()
                ->select('noticias.id ,titulo, img, subtitulo,creador_id, noticias.created_at')
                ->joinWith('creador')
                ->orderBy(['created_at' => SORT_DESC])
                ->limit(Noticias::PAGESIZE)
                ->offset($page)
                ->all();

        $a = '';

        foreach ($model as $noticia) {
            $a .= $this->renderAjax('_noticias', [
                'noticia' => $noticia,
            ]);
        }

        return $a;
    }

    /**
     * Displays a single Noticias model.
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
     * Creates a new Noticias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Noticias();

        if ($model->load(Yii::$app->request->post())) {
            $model->creador_id = Yii::$app->user->identity->id;
            $model->img = UploadedFile::getInstance($model, 'img');

            if ($model->img) {
                $model->extension = $model->img->extension;
            }

            //die();
            if ($model->upload() && $model->save()) {
                return $this->goHome();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Noticias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        /*$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);*/
    }

    /**
     * Deletes an existing Noticias model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        /*$this->findModel($id)->delete();

        return $this->redirect(['index']);*/
    }

    /**
     * Finds the Noticias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Noticias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Noticias::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
