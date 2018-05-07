<?php

namespace app\controllers;

use app\models\Respuestas;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\widgets\ListView;

class RespuestasController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create-padre', 'crear'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create-padre', 'crear'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    /**
     * Crear un comentario de un comentario.
     * @return [type] [description]
     */
    public function actionCreatePadre()
    {
        return $this->crear(Respuestas::ESCENARIO_EQUIPO_PADRE);
    }

    /**
     * Crea el comentario de un post.
     * @return [type] [description]
     */
    public function actionCreate()
    {
        return $this->crear(Respuestas::ESCENARIO_EQUIPO);
    }

    public function crear($escenario)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            $model = new Respuestas();
            $model->scenario = $escenario;
            $model->texto = Yii::$app->request->post('comentario');
            $model->post_id = Yii::$app->request->post('noticia');
            $model->padre_id = Yii::$app->request->post('padre_id');

            $model->creador_id = Yii::$app->user->identity->id;
            //var_dump($model);
            if ($model->save()) {
                $model->refresh();
                return ListView::widget([
                            'dataProvider' => new ActiveDataProvider([
                                'query' => Respuestas::find()->where(['id' => $model->id]),
                            ]),
                            'itemView' => '/posts/_respuestas',
                            'summary' => '',
                    ]);
            }
            //var_dump($model->errors);
            return false;
        }
    }
}