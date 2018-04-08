<?php

namespace app\controllers;

use app\models\Comentarios;
use Yii;
use yii\data\ActiveDataProvider;
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
}
