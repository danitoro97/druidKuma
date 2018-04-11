<?php

namespace app\models;

/**
 * This is the model class for table "respuestas".
 *
 * @property int $id
 * @property string $texto
 * @property int $post_id
 * @property int $padre_id
 *
 * @property Posts $post
 * @property Respuestas $padre
 * @property Respuestas[] $respuestas
 */
class Respuestas extends \yii\db\ActiveRecord
{
    /**
     * Escenario que se usara cuando el posts sea para un equipo.
     * @var string
     */
    const ESCENARIO_EQUIPO = 'equipo';
    /**
     * Escenario que se va a usar cuando el posts sea para un equipo y una respuesta.
     * @var string
     */
    const ESCENARIO_EQUIPO_PADRE = 'equipo Padre';
    /**
     * Escenario que se utilizara cuando el posts sea para el foro.
     * @var string
     */
    const ESCENARIO_FORO = 'foro';
    /**
     * Escenario que se va a usar cuando se envie un comentario de un comentario.
     * @var string
     */
    const ESCENARIO_FORO_PADRE = 'equipo foro';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respuestas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['texto'], 'required'],
            [['texto'], 'string'],
            [['post_id'], 'required', 'on' => [self::ESCENARIO_EQUIPO, self::ESCENARIO_FORO]],
            [['padre_id'], 'required', 'on' => [self::ESCENARIO_EQUIPO_PADRE, self::ESCENARIO_FORO_PADRE]],
            [['usuario_id'], function ($attributes, $params, $validador) {
                if (Participantes::find()
                ->where(['equipo_id' => $this->equipo_usuario_id])
                ->andWhere(['usuario_id' => $this->creador_id])->one() == null) {
                    $this->addError($attributes, 'El usuario no pertenece al equipo');
                }
            }, 'on' => [self::ESCENARIO_EQUIPO, self::ESCENARIO_EQUIPO_PADRE]],
            [['post_id', 'padre_id'], 'default', 'value' => null],
            [['post_id', 'padre_id'], 'integer'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['padre_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'texto' => 'Texto',
            'post_id' => 'Post ID',
            'padre_id' => 'Padre ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id'])->inverseOf('respuestas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPadre()
    {
        return $this->hasOne(self::className(), ['id' => 'padre_id'])->inverseOf('respuestas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestas()
    {
        return $this->hasMany(self::className(), ['padre_id' => 'id'])->inverseOf('padre');
    }
}
