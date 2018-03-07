<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $token_val
 * @property int $role_id
 * @property string $created_at
 *
 * @property Noticias[] $noticias
 * @property Roles $role
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
            'class' => TimestampBehavior::className(),
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'value' => new Expression('NOW()'),
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email', 'password'], 'required'],
            [['role_id'], 'default', 'value' => 1],
            [['role_id'], 'integer'],
            //[['created_at'], 'safe'],
            [['nombre', 'email', 'password', 'auth_key', 'token_val'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['nombre'], 'unique'],
            [['token_val'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['role_id' => 'id']],
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
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'token_val' => 'Token Val',
            'role_id' => 'Role ID',
            'created_at' => 'Created At',
        ];
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
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role_id'])->inverseOf('usuarios');
    }
}
