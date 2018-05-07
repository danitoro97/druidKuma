<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentar_partidos".
 *
 * @property int $id
 * @property int $partido_id
 * @property int $usuario_id
 * @property string $texto
 * @property string $created_at
 *
 * @property Partidos $partido
 * @property Usuarios $usuario
 */
class ComentarPartidos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentar_partidos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partido_id', 'usuario_id', 'texto'], 'required'],
            [['partido_id', 'usuario_id'], 'default', 'value' => null],
            [['partido_id', 'usuario_id'], 'integer'],
            [['created_at'], 'safe'],
            [['texto'], 'string', 'max' => 255],
            [['partido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partidos::className(), 'targetAttribute' => ['partido_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partido_id' => 'Partido ID',
            'usuario_id' => 'Usuario ID',
            'texto' => 'Texto',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartido()
    {
        return $this->hasOne(Partidos::className(), ['id' => 'partido_id'])->inverseOf('comentarPartidos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('comentarPartidos');
    }
}
