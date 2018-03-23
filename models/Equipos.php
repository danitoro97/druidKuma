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

    public function getPartidosJugadosLocal()
    {
        return $this->getPartidos()->where(['estado' => 'FINISHED'])->count();
    }

    public function getPartidosJugadosVisitante()
    {
        return $this->getPartidos0()->where(['estado' => 'FINISHED'])->count();
    }

    public function getPartidosJugados()
    {
        return $this->getPartidosJugadosLocal() + $this->getPartidosJugadosVisitante();
    }

    public function getGolesLocal()
    {
        return $this->getPartidos()->sum('goles_local');
    }

    public function getGolesVisitante()
    {
        return $this->getPartidos0()->sum('goles_visitante');
    }

    public function getGolesFavor()
    {
        return $this->golesLocal + $this->golesVisitante;
    }

    public function getVictoriasLocal()
    {
        return $this->getPartidos()->where('coalesce(goles_local,0) > coalesce(goles_visitante,0)')->count();
    }

    public function getVictoriasVisitante()
    {
        return $this->getPartidos0()->where('coalesce(goles_local,0)< coalesce(goles_visitante,0)')->count();
    }

    public function getVictorias()
    {
        return $this->victoriasLocal + $this->victoriasVisitante;
    }

    public function getDerrotasLocal()
    {
        return $this->getPartidos()->where('coalesce(goles_local,0) < coalesce(goles_visitante,0)')->count();
    }

    public function getDerrotasVisitante()
    {
        return $this->getPartidos0()->where('coalesce(goles_local,0) > coalesce(goles_visitante,0)')->count();
    }

    public function getDerrotas()
    {
        return $this->derrotasLocal + $this->derrotasVisitante;
    }

    public function getGolesContraLocal()
    {
        return $this->getPartidos0()->sum('goles_local');
    }

    public function getGolesContraVisitante()
    {
        return $this->getPartidos()->sum('goles_visitante');
    }

    public function getGolesContra()
    {
        return $this->golesContraLocal + $this->golesContraVisitante;
    }

    public function getPuntos()
    {
        $empates = ($this->partidosJugados - $this->victorias) - $this->derrotas;
        return $this->victorias * 3 + $empates;
    }

    public function getDiff()
    {
        return $this->golesFavor - $this->golesContra;
    }
}
