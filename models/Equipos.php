<?php

namespace app\models;

/**
 * This is the model class for table "equipos".
 *
 * @property int $id
 * @property string $nombre
 * @property string $alias
 * @property int $liga_id
 *
 * @property Ligas $liga
 * @property Jugadores[] $jugadores
 * @property Partidos[] $partidos
 * @property Partidos[] $partidos0
 */
class Equipos extends \yii\db\ActiveRecord
{
    public const FINALIZADO = 'FINISHED';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'liga_id'], 'required'],
            [['liga_id'], 'default', 'value' => null],
            [['liga_id'], 'integer'],
            [['nombre', 'alias'], 'string', 'max' => 255],
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
            'nombre' => 'Nombre',
            'alias' => 'Alias',
            'liga_id' => 'Liga ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLiga()
    {
        return $this->hasOne(Ligas::className(), ['id' => 'liga_id'])->inverseOf('equipos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJugadores()
    {
        return $this->hasMany(Jugadores::className(), ['equipo_id' => 'id'])->inverseOf('equipo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidos()
    {
        return $this->hasMany(Partidos::className(), ['local_id' => 'id'])->inverseOf('local');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidos0()
    {
        return $this->hasMany(Partidos::className(), ['visitante_id' => 'id'])->inverseOf('visitante');
    }


    /**
     * Devuelve la cantidad de partidos jugados hasta ahora.
     * @return [type] [description]
     */
    public function getPartidosJugados()
    {
        return $this->getPartidos()->where(['estado' => self::FINALIZADO])->count()
        + $this->getPartidos0()->where(['estado' => self::FINALIZADO])->count();
    }

    /**
     * Devuelve la cantidad de goles metidos por el equipo.
     * @return [type] [description]
     */
    public function getGolesFavor()
    {
        return $this->getPartidos()->sum('goles_local')
        + $this->getPartidos0()->sum('goles_visitante');
    }

    /**
     * Devuelve la cantidad de partidos ganados.
     * @return [type] [description]
     */
    public function getVictorias()
    {
        return $this->getPartidos()
                ->where('coalesce(goles_local,0) > coalesce(goles_visitante,0)')
                ->count() +
                $this->getPartidos0()
                ->where('coalesce(goles_local,0)< coalesce(goles_visitante,0)')
                ->count();
    }
    /**
     * Devuelve la cantidad de partidos perdidos.
     * @return [type] [description]
     */
    public function getDerrotas()
    {
        return $this->getPartidos()->where('coalesce(goles_local,0) < coalesce(goles_visitante,0)')->count()
        + $this->getPartidos0()->where('coalesce(goles_local,0) > coalesce(goles_visitante,0)')->count();
    }

    /**
     * Devuelve la cantidad de goles encajado por el equipo.
     * @return [type] [description]
     */
    public function getGolesContra()
    {
        return $this->getPartidos0()->sum('goles_local')
        + $this->getPartidos()->sum('goles_visitante');
    }

    /**
     * Devuelve la cantidad de partidos empatados.
     * @return [type] [description]
     */
    public function getEmpates()
    {
        return ($this->partidosJugados - $this->victorias) - $this->derrotas;
    }

    /**
     * Devuelve la cantidad de puntos ganados por el equipo.
     * @return [type] [description]
     */
    public function getPuntos()
    {
        return $this->victorias * 3 + $this->empates;
    }

    /**
     * Devuelve la diferencia entre goles a favor y en contra.
     * @return [type] [description]
     */
    public function getDiff()
    {
        return $this->golesFavor - $this->golesContra;
    }
}
