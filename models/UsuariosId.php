<?php

namespace app\models;

/**
 * This is the model class for table "usuarios_id".
 *
 * @property int $id
 *
 * @property Comentarios[] $comentarios
 * @property EquiposUsuarios[] $equiposUsuarios
 * @property Noticias[] $noticias
 * @property Participantes[] $participantes
 * @property EquiposUsuarios[] $equipos
 * @property Usuarios $usuarios
 */
class UsuariosId extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios_id';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquiposUsuarios()
    {
        return $this->hasMany(EquiposUsuarios::className(), ['creador_id' => 'id'])->inverseOf('creador');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticias()
    {
        return $this->hasMany(Noticias::className(), ['creador_id' => 'id'])->inverseOf('creador');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantes()
    {
        return $this->hasMany(Participantes::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(EquiposUsuarios::className(), ['id' => 'equipo_id'])->viaTable('participantes', ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id'])->inverseOf('id0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['creador_id' => 'id'])->inverseOf('creador');
    }
}
