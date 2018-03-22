<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posiciones".
 *
 * @property int $id
 * @property string $nombre
 * @property string $siglas
 *
 * @property Jugadores[] $jugadores
 */
class Posiciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posiciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
            [['siglas'], 'string', 'max' => 10],
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
            'siglas' => 'Siglas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJugadores()
    {
        return $this->hasMany(Jugadores::className(), ['posicion_id' => 'id'])->inverseOf('posicion');
    }
}
