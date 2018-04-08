<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property string $comentario
 * @property int $noticia_id
 * @property int $usuario_id
 * @property int $padre_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Comentarios $padre
 * @property Comentarios[] $comentarios
 * @property Noticias $noticia
 * @property UsuariosId $usuario
 */
class Comentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comentario'], 'string'],
            [['noticia_id', 'usuario_id'], 'required'],
            [['noticia_id', 'usuario_id', 'padre_id'], 'default', 'value' => null],
            [['noticia_id', 'usuario_id', 'padre_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['padre_id' => 'id']],
            [['noticia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Noticias::className(), 'targetAttribute' => ['noticia_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * Comportamiento para añadir hora de creacion y modifiacion.
     * @return [type] [description]
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
            'class' => TimestampBehavior::className(),
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'value' => new Expression('NOW()'),
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comentario' => 'Comentario',
            'noticia_id' => 'Noticia ID',
            'usuario_id' => 'Usuario ID',
            'padre_id' => 'Padre ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPadre()
    {
        return $this->hasOne(self::className(), ['id' => 'padre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(self::className(), ['padre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticia()
    {
        return $this->hasOne(Noticias::className(), ['id' => 'noticia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id']);
    }
}
