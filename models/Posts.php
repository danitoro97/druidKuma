<?php

namespace app\models;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $creador_id
 * @property int $equipo_usuario_id
 * @property string $texto
 * @property string $img
 *
 * @property EquiposUsuarios $equipoUsuario
 * @property UsuariosId $creador
 * @property Respuestas[] $respuestas
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * Escenario que se usara cuando el posts sea para un equipo.
     * @var string
     */
    const ESCENARIO_EQUIPO = 'equipo';

    /**
     * Escenario que se utilizara cuando el posts sea para el foro.
     * @var string
     */
//    const ESCENARIO_FORO = 'foro';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creador_id'], 'required'],
            [['equipo_usuario_id'], 'required', 'on' => self::ESCENARIO_EQUIPO],
            [['creador_id'], function ($attributes, $params, $validador) {
                if (Participantes::find()
                ->where(['equipo_id' => $this->equipo_usuario_id])
                ->andWhere(['usuario_id' => $this->creador_id])->one() == null) {
                    $this->addError($attributes, 'El usuario no pertenece al equipo');
                }//Y este aceptado
            }, 'on' => self::ESCENARIO_EQUIPO],
            [['creador_id', 'equipo_usuario_id'], 'default', 'value' => null],
            [['creador_id', 'equipo_usuario_id'], 'integer'],
            [['texto'], 'string'],
            [['img'], 'string', 'max' => 255],
            [['equipo_usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquiposUsuarios::className(), 'targetAttribute' => ['equipo_usuario_id' => 'id']],
            [['creador_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['creador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creador_id' => 'Creador ID',
            'equipo_usuario_id' => 'Equipo Usuario ID',
            'texto' => 'Texto',
            'img' => 'Img',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipoUsuario()
    {
        return $this->hasOne(EquiposUsuarios::className(), ['id' => 'equipo_usuario_id'])->inverseOf('posts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreador()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'creador_id'])->inverseOf('posts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestas()
    {
        return $this->hasMany(Respuestas::className(), ['post_id' => 'id'])->inverseOf('post');
    }
}
