<?php

namespace app\controllers;

use app\models\Comentarios;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\widgets\ListView;

class ComentariosController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Crear un comentario de una noticia.
     * @return [type] [description]
     */
    public function actionCreate()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            $model = new Comentarios();
            $model->comentario = Yii::$app->request->post('comentario');
            $model->noticia_id = Yii::$app->request->post('noticia');
            $model->padre_id = Yii::$app->request->post('padre_id');
            if (Yii::$app->request->post('escenario') == Comentarios::ESCENARIO_NOTICIA) {
                $model->scenario = Comentarios::ESCENARIO_NOTICIA;
            }

            if (Yii::$app->request->post('escenario') == Comentarios::ESCENARIO_PADRE) {
                $model->scenario = Comentarios::ESCENARIO_PADRE;
            }

            $model->usuario_id = Yii::$app->user->identity->id;

            if ($model->save()) {
                $model->refresh();
                return ListView::widget([
                        'dataProvider' => new ActiveDataProvider([
                            'query' => Comentarios::find()->where(['id' => $model->id]),
                        ]),
                        'itemView' => '/comentarios/_comentarios',
                        'summary' => '',
                ]);
            }

            return false;
        }
    }
    /**
     * Devuelve una vista con los comentarios de la noticia.
     * @param  [type] $id [description]
     * @param mixed $pagination
     * @return [type]     [description]
     */
    public function actionView($id)
    {
        if (Yii::$app->request->isAjax) {
            return ListView::widget([
                    'dataProvider' => new ActiveDataProvider([
                        'query' => Comentarios::find()
                                    ->orderBy('created_at ASC')
                                    ->where('padre_id is null')
                                    ->andWhere(['noticia_id' => $id]),
                        'pagination' => false,
                    ]),
                    'itemView' => '/comentarios/_comentarios',
                    'summary' => '',
            ]);
        }
    }


    /**
     * Finds the Noticias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Comentarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
