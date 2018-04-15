<?php

namespace app\models;

/**
 * This is the model class for table "jugadores".
 *
 * @property int $id
 * @property string $nombre
 * @property int $posicion_id
 * @property string $dorsal
 * @property string $contrato
 * @property int $equipo_id
 *
 * @property Equipos $equipo
 * @property Posiciones $posicion
 */
class Jugadores extends \yii\db\ActiveRecord
{
    /**
     * Numero de jugadores que se veran en el carusel.
     * @var string
     */
    const CARROUSEL = '3';

    /**
     * foto que se mostrara si no tiene.
     * @var string
     */
    const FOTO = '@web/futbolista.png';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jugadores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'posicion_id', 'equipo_id'], 'required'],
            [['posicion_id', 'equipo_id'], 'default', 'value' => null],
            [['posicion_id', 'equipo_id'], 'integer'],
            [['dorsal'], 'number'],
            [['nombre', 'contrato'], 'string', 'max' => 255],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipos::className(), 'targetAttribute' => ['equipo_id' => 'id']],
            [['posicion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posiciones::className(), 'targetAttribute' => ['posicion_id' => 'id']],
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
            'posicion_id' => 'Posicion ID',
            'dorsal' => 'Dorsal',
            'contrato' => 'Contrato',
            'equipo_id' => 'Equipo ID',
        ];
    }

    /**
     * Obtener la foto del jugador.
     * @return [type] [description]
     */
    public function getFoto()
    {
        return $this->url == null ? self::FOTO : $this->url;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(Equipos::className(), ['id' => 'equipo_id'])->inverseOf('jugadores');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosicion()
    {
        return $this->hasOne(Posiciones::className(), ['id' => 'posicion_id'])->inverseOf('jugadores');
    }
}
