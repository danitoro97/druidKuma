<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ligas".
 *
 * @property int $id
 * @property string $nombre
 * @property int $pais_id
 * @property string $siglas
 *
 * @property Equipos[] $equipos
 * @property Paises $pais
 * @property Partidos[] $partidos
 */
class Ligas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ligas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'pais_id'], 'required'],
            [['pais_id'], 'default', 'value' => null],
            [['pais_id'], 'integer'],
            [['nombre', 'siglas'], 'string', 'max' => 255],
            [['nombre'], 'unique'],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paises::className(), 'targetAttribute' => ['pais_id' => 'id']],
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
            'pais_id' => 'Pais ID',
            'siglas' => 'Siglas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipos::className(), ['liga_id' => 'id'])->inverseOf('liga');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPais()
    {
        return $this->hasOne(Paises::className(), ['id' => 'pais_id'])->inverseOf('ligas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidos()
    {
        return $this->hasMany(Partidos::className(), ['liga_id' => 'id'])->inverseOf('liga');
    }
}
