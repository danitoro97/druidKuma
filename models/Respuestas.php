<?php

namespace app\models;

use yii\helpers\Html;

/**
 * This is the model class for table "respuestas".
 *
 * @property int $id
 * @property string $texto
 * @property int $usuario_id
 * @property int $post_id
 * @property int $padre_id
 *
 * @property Posts $post
 * @property Respuestas $padre
 * @property Respuestas[] $respuestas
 * @property UsuariosId $creador
 */
class Respuestas extends \yii\db\ActiveRecord
{
    /**
     * Escenario para cuando se responda al post de un equipo.
     * @var [type]
     */
    public const ESCENARIO_EQUIPO = 'equipo';

    public const ESCENARIO_EQUIPO_PADRE = 'padre';

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
            [['comentario', 'usuario_id', 'post_id'], 'required'],
            [['padre_id'], 'required', 'on' => self::ESCENARIO_EQUIPO_PADRE],
            [['comentario'], 'string'],
            [['usuario_id', 'post_id', 'padre_id'], 'default', 'value' => null],
            [['usuario_id', 'post_id', 'padre_id'], 'integer'],
            [['usuario_id'], function ($attributes) {
                $post = Posts::findOne($this->post_id);

                $participante = Participantes::find()
                                ->where(['equipo_id' => $post->equipo_usuario_id])
                                ->andWhere(['usuario_id' => $this->usuario_id])
                                ->exists();

                if (!$participante) {
                    $this->addError('usuario_id', ' Usuario no valido');
                }
            }, 'on' => [self::ESCENARIO_EQUIPO, self::ESCENARIO_EQUIPO_PADRE]],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['padre_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_id' => 'id']],
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
            'usuario_id' => 'Creador ID',
            'post_id' => 'Post ID',
            'padre_id' => 'Padre ID',
        ];
    }

    public function getCreadorNombre()
    {
        return ($this->usuario->usuarios->nombre) ? Html::encode($this->usuario->usuarios->nombre) : 'anonimo';
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(self::className(), ['padre_id' => 'id'])->inverseOf('padre');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('respuestas');
    }
}
