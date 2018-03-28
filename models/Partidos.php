<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "partidos".
 *
 * @property int $id
 * @property string $fecha
 * @property int $local_id
 * @property int $visitante_id
 * @property int $liga_id
 * @property string $estado
 * @property string $goles_local
 * @property string $goles_visitante
 *
 * @property Equipos $local
 * @property Equipos $visitante
 * @property Ligas $liga
 */
class Partidos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partidos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha'], 'safe'],
            [['local_id', 'visitante_id', 'liga_id'], 'required'],
            [['local_id', 'visitante_id', 'liga_id'], 'default', 'value' => null],
            [['local_id', 'visitante_id', 'liga_id'], 'integer'],
            [['goles_local', 'goles_visitante'], 'number'],
            [['estado'], 'string', 'max' => 255],
            [['local_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipos::className(), 'targetAttribute' => ['local_id' => 'id']],
            [['visitante_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipos::className(), 'targetAttribute' => ['visitante_id' => 'id']],
            [['liga_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ligas::className(), 'targetAttribute' => ['liga_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'local_id' => 'Local ID',
            'visitante_id' => 'Visitante ID',
            'liga_id' => 'Liga ID',
            'estado' => 'Estado',
            'goles_local' => 'Goles Local',
            'goles_visitante' => 'Goles Visitante',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocal()
    {
        return $this->hasOne(Equipos::className(), ['id' => 'local_id'])->inverseOf('partidos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitante()
    {
        return $this->hasOne(Equipos::className(), ['id' => 'visitante_id'])->inverseOf('partidos0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLiga()
    {
        return $this->hasOne(Ligas::className(), ['id' => 'liga_id'])->inverseOf('partidos');
    }
}
