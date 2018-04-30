<?php

namespace app\models;

use yii\helpers\Html;

/**
 * This is the model class for table "respuestas".
 *
 * @property int $id
 * @property string $texto
 * @property int $creador_id
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
            [['texto', 'creador_id'], 'required'],
            [['texto'], 'string'],
            [['creador_id', 'post_id', 'padre_id'], 'default', 'value' => null],
            [['creador_id', 'post_id', 'padre_id'], 'integer'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['padre_id' => 'id']],
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
            'texto' => 'Texto',
            'creador_id' => 'Creador ID',
            'post_id' => 'Post ID',
            'padre_id' => 'Padre ID',
        ];
    }

    public function getCreadorNombre()
    {
        return ($this->creador->usuarios->nombre) ? Html::encode($this->creador->usuarios->nombre) : 'anonimo';
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
    public function getCreador()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'creador_id'])->inverseOf('respuestas');
    }
}
