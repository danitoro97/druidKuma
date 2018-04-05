<?php

namespace app\controllers;

use app\models\Comentarios;
use Yii;

class ComentariosController extends \yii\web\Controller
{
    public function actionCreate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (Yii::$app->request->post() != null) {
                $model = new Comentarios();
                $model->comentario = Yii::$app->request->post('comentario');
                $model->noticia_id = Yii::$app->request->post('noticia');
                $model->usuario_id = Yii::$app->user->identity->id;

                if ($model->save()) {
                    return $model;
                }
            }
            return false;
        }
    }
}
