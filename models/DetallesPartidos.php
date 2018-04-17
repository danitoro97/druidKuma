<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalles_partidos".
 *
 * @property int $id
 * @property int $partido_id
 * @property int $equipo_id
 * @property string $minuto
 * @property int $jugador_id
 * @property bool $roja
 * @property bool $amarilla
 * @property bool $gol
 * @property bool $autogol
 *
 * @property Equipos $equipo
 * @property Jugadores $jugador
 * @property Partidos $partido
 */
class DetallesPartidos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalles_partidos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partido_id', 'equipo_id', 'jugador_id'], 'required'],
            [['partido_id', 'equipo_id', 'jugador_id'], 'default', 'value' => null],
            [['partido_id', 'equipo_id', 'jugador_id'], 'integer'],
            [['roja', 'amarilla', 'gol', 'autogol'], 'boolean'],
            [['minuto'], 'string', 'max' => 255],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipos::className(), 'targetAttribute' => ['equipo_id' => 'id']],
            [['jugador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Jugadores::className(), 'targetAttribute' => ['jugador_id' => 'id']],
            [['partido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partidos::className(), 'targetAttribute' => ['partido_id' => 'id']],
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
            'equipo_id' => 'Equipo ID',
            'minuto' => 'Minuto',
            'jugador_id' => 'Jugador ID',
            'roja' => 'Roja',
            'amarilla' => 'Amarilla',
            'gol' => 'Gol',
            'autogol' => 'Autogol',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(Equipos::className(), ['id' => 'equipo_id'])->inverseOf('detallesPartidos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJugador()
    {
        return $this->hasOne(Jugadores::className(), ['id' => 'jugador_id'])->inverseOf('detallesPartidos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartido()
    {
        return $this->hasOne(Partidos::className(), ['id' => 'partido_id'])->inverseOf('detallesPartidos');
    }
}
