<?php

namespace app\models;

/**
 * This is the model class for table "participantes".
 *
 * @property int $equipo_id
 * @property int $usuario_id
 *
 * @property EquiposUsuarios $equipo
 * @property UsuariosId $usuario
 */
class Participantes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participantes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipo_id'], 'required'],
            [['equipo_id', 'usuario_id'], 'default', 'value' => null],
            [['equipo_id', 'usuario_id'], 'unique', 'targetAttribute' => ['equipo_id', 'usuario_id']],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquiposUsuarios::className(), 'targetAttribute' => ['equipo_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'equipo_id' => 'Equipo ID',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(EquiposUsuarios::className(), ['id' => 'equipo_id'])->inverseOf('participantes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('participantes');
    }
}
