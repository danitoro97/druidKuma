<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\IdentityInterface;

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
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['password_repeat']);
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
            [['nombre', 'email', 'password', 'password_repeat'], 'required'],
            [['role_id'], 'default', 'value' => 1],
            [['role_id'], 'integer'],
            [['email'], 'email'],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password'],
            [['password'], function ($attributes, $params, $validador) {
                if (mb_strlen($this->$attributes) < 7) {
                    $this->addError($attributes, 'La contraseña debe ser al menos de 7 caracteres');
                }
            }],
            [['nombre', 'email', 'password', 'auth_key', 'token_val'], 'string', 'max' => 255],
            [['auth_key', 'token_val', 'email', 'nombre'], 'unique'],
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
            'nombre' => 'Nombre de usuario',
            'email' => 'Email',
            'password' => 'Contraseña',
            'auth_key' => 'Auth Key',
            'token_val' => 'Token Val',
            'role_id' => 'Role ID',
            'created_at' => 'Created At',
            'password_repeat' => 'Confirmar contraseña',
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


    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @param null|mixed $type
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $key = Yii::$app->security->generateRandomString();

                while (self::findOne(['auth_key' => $key]) != null) {
                    $key = Yii::$app->security->generateRandomString();
                }
                $this->auth_key = $key = Yii::$app->security->generateRandomString();
                $key = Yii::$app->security->generateRandomString();

                while (self::findOne(['token_val' => $key]) != null) {
                    $key = Yii::$app->security->generateRandomString();
                }

                $this->token_val = $key = Yii::$app->security->generateRandomString();
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }
}
