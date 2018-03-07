<?php

namespace app\models;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Usuarios[] $usuarios
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * [public description].
     * @var [type]
     */
    public const CREADOR = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['role_id' => 'id'])->inverseOf('role');
    }
}
