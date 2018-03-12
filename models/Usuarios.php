<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Url;
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
    /**
     * Variable para comprobar que introduce la misma contraseña dos veces.
     * @var [type]
     */
    public $password_repeat;

    /**
     * Constante para el escenario crear.
     * @var string
     */
    public const ESCENARIO_CREAR = 'crear';

    /**
     * Constante para el escenario actualizar.
     * @var string
     */
    public const ESCENARIO_ACTUALIZAR = 'actualizar';

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
            [['nombre', 'email'], 'required'],
            [['password_repeat', 'password'], 'required', 'on' => self::ESCENARIO_CREAR],
            [['role_id'], 'default', 'value' => 1],
            [['role_id'], 'integer'],
            [['email'], 'email'],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'on' => [self::ESCENARIO_CREAR, self::ESCENARIO_ACTUALIZAR]],
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
            'created_at' => 'Fecha de alta',
            'updated_at' => 'Última actualización',
            'password_repeat' => 'Confirmar contraseña',
        ];
    }
    /**
     * Si el usuario es visible.
     * @return bool [description]
     */
    public function isNotVisible()
    {
        return $this->soft_delete;
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

    /**
     * Realiza modificaciones el modelo antes de insertar.
     * @param  bool $insert    Verdadero si es insert falso si es update
     * @return [type]         [description]
     */
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
                if ($this->scenario == self::ESCENARIO_CREAR) {
                    $this->password = Yii::$app->security->generatePasswordHash($this->password);
                }
                $this->token_val = $key = Yii::$app->security->generateRandomString();
            } else {
                //Actualizar
                if ($this->scenario == self::ESCENARIO_ACTUALIZAR) {
                    if ($this->nombre == '') {
                        $this->nombre = $this->getOldAttribute('nombre');
                    }

                    if ($this->email == '') {
                        $this->email = $this->getOldAttribute('email');
                    }

                    if ($this->email != $this->getOldAttribute('email')) {
                        $key = Yii::$app->security->generateRandomString();

                        while (self::findOne(['token_val' => $key]) != null) {
                            $key = Yii::$app->security->generateRandomString();
                        }
                        $this->token_val = $key = Yii::$app->security->generateRandomString();
                        //mandar correo
                        $this->enviarCorreo();
                        Yii::$app->user->logout();
                        Yii::$app->session->setFlash('info', 'Haz cambiado el correo debes validar la cuenta , para ello revise su correo');
                    }

                    if ($this->password == '') {
                        $this->password = $this->getOldAttribute('password');
                    } else {
                        $this->password = Yii::$app->security->generatePasswordHash($this->password);
                    }
                }
            }


            return true;
        }
        return false;
    }

    public function enviarCorreo()
    {
        return Yii::$app->mailer->compose('validacion', ['token_val' => $this->token_val])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($this->email)
                ->setSubject('Correo de confirmacion de DruidKuma')
                ->setTextBody('Hola, bienvenido a DruidKuma ' .
                Url::to(['usuarios/validar', 'token_val' => $this->token_val], true)
                . ' Gracias,DruidKuma')
                ->send();
    }
}
