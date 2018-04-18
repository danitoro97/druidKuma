<?php

namespace app\models;

/**
 * This is the model class for table "equipos_usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property int $creador_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Usuarios $creador
 * @property Participantes[] $participantes
 * @property Usuarios[] $usuarios
 */
class EquiposUsuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipos_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creador_id'], 'required'],
            [['creador_id'], 'default', 'value' => null],
            [['creador_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['nombre'], 'unique'],
            [['creador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['creador_id' => 'id']],
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
            'creador_id' => 'Creador ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreador()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'creador_id'])->inverseOf('equiposUsuarios');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantes()
    {
        return $this->hasMany(Participantes::className(), ['equipo_id' => 'id'])->inverseOf('equipo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'usuario_id'])->viaTable('participantes', ['equipo_id' => 'id']);
    }

    /**
     * Un participante es activo cuando ha aceptado la peticion.
     * @return [type] [description]
     */
    public function getParticipantesActivos()
    {
        return $this->getParticipantes()->where(['aceptar = true']);
    }

    /**
     * Anade el primer participante al equipo que sera el creador.
     * @param  bool $insert    Verdadero si es insert falso si es update
     * @param mixed $changedAttributes
     * @return [type]         [description]
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $participante = new Participantes();
            $participante->usuario_id = $this->creador_id;
            $participante->equipo_id = $this->id;
            return $participante->save();
        }
    }
}
