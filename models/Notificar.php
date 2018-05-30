<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Notificar extends Model
{
    /**
     * Variable para el nombre del usuario.
     * @var [type]
     */
    public $name;

    /**
     * Variable para el email.
     * @var [type]
     */
    public $email;

    /**
     * Variable para la descripcion dle problema.
     * @var [type]
     */
    public $texto;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'texto'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'texto' => 'Descripcion del problema o de la sugerencia',
            'nombre' => 'Nombre',
            'email' => 'Email',
        ];
    }

    /**
     * Me envia un correo a mi mismo con la notificacion del visitante.
     * @return [type] [description]
     */
    public function enviar()
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose('notificacion', [
                'nombre' => $this->name,
                'texto' => $this->texto,
                'email' => $this->email,
            ])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo(Yii::$app->params['adminEmail'])
                    ->setSubject('Notificacion de error')
                    //->setTextBody('Hola, bienvenido a DruidKuma ' . $enlace . ' Gracias,DruidKuma')
                    ->send();
            return true;
        }
        return false;
    }
}
