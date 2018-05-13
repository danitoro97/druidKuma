<?php

namespace app\controllers;

use app\models\ComentarPartidos;
use Yii;
use yii\filters\AccessControl;

class ComentarPartidosController extends \yii\web\Controller
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
     * Action que crea un comentario de un partido.
     * @return [type] [description]
     */
    public function actionCreate()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            $model = new ComentarPartidos();
            $model->usuario_id = Yii::$app->user->identity->id;
            $model->partido_id = Yii::$app->request->post('partido_id');
            $model->comentario = Yii::$app->request->post('texto');

            if ($model->save()) {
                $model->refresh();
                return $this->renderPartial('/comentarios/_comentarios', ['model' => $model, 'padre' => true]);
            }
        }
        return false;
    }
}
