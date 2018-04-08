<?php

namespace app\controllers;

use app\models\Comentarios;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\widgets\ListView;

class ComentariosController extends \yii\web\Controller
{
    public function actionCreate()
    {
        if (Yii::$app->request->isAjax) {
            //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (Yii::$app->request->post() != null) {
                $model = new Comentarios();
                $model->comentario = Yii::$app->request->post('comentario');
                $model->noticia_id = Yii::$app->request->post('noticia');
                $model->padre_id = Yii::$app->request->post('padre_id');
                $model->usuario_id = Yii::$app->user->identity->id;

                if ($model->save()) {
                    $model->refresh();
                    return ListView::widget([
                            'dataProvider' => new ActiveDataProvider([
                                'query' => Comentarios::find()->where(['id' => $model->id]),
                            ]),
                            'itemView' => '/noticias/_comentarios',
                            'summary' => '',
                    ]);
                }
            }
            return false;
        }
    }

    public function actionView($id)
    {
        if (Yii::$app->request->isAjax) {
            $model = $this->findModel($id);
            return ListView::widget([
                    'dataProvider' => new ActiveDataProvider([
                        'query' => Comentarios::find()
                                    ->orderBy('created_at ASC')
                                    ->where('padre_id is null')
                                    ->andWhere(['noticia_id' => $id]),
                    ]),
                    'itemView' => '/noticias/_comentarios',
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
