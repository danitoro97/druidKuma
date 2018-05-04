<?php

namespace app\models;

use Spatie\Dropbox\Exceptions\BadRequest;
use yii\imagine\Image;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $creador_id
 * @property int $equipo_usuario_id
 * @property string $texto
 * @property string $titulo
 * @property string $img
 *
 * @property EquiposUsuarios $equipoUsuario
 * @property UsuariosId $creador
 * @property Respuestas[] $respuestas
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * Varaible que almacenara el canvas en base 64.
     * @var [type]
     */
    public $canvas;
    /**
     * Escenario que se usara cuando el posts sea para un equipo.
     * @var string
     */
    const ESCENARIO_EQUIPO = 'equipo';

    /**
     * Escenario que se utilizara cuando el posts sea para el foro.
     * @var string
     */
//    const ESCENARIO_FORO = 'foro';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creador_id', 'titulo', 'canvas'], 'required'],
            [['equipo_usuario_id'], 'required', 'on' => self::ESCENARIO_EQUIPO],
            [['creador_id'], function ($attributes, $params, $validador) {
                if (Participantes::find()
                ->where(['equipo_id' => $this->equipo_usuario_id])
                ->andWhere(['usuario_id' => $this->creador_id])->one() == null) {
                    $this->addError($attributes, 'El usuario no pertenece al equipo');
                }//Y este aceptado
            }, 'on' => self::ESCENARIO_EQUIPO],
            [['creador_id', 'equipo_usuario_id'], 'default', 'value' => null],
            [['creador_id', 'equipo_usuario_id'], 'integer'],
            [['texto'], 'string'],
            [['img'], 'string', 'max' => 255],
            [['equipo_usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquiposUsuarios::className(), 'targetAttribute' => ['equipo_usuario_id' => 'id']],
            [['creador_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['creador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creador_id' => 'Creador ID',
            'equipo_usuario_id' => 'Equipo Usuario ID',
            'texto' => 'Texto',
            'img' => 'Img',
        ];
    }

    /**
     * Carga la img en disco y la sube a Dropbox.
     * @return [type] [description]
     */
    public function upload()
    {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->canvas));
        $id = self::find()->orderBy('id DESC')->one()->id + 1;
        $filepath = getenv('RutaPosts') . $id . '.png'; // or image.jpg

        // Save the image in a defined path
        file_put_contents($filepath, $data);

        $client = new \Spatie\Dropbox\Client(getenv('Dropbox'));

        try {
            $client->delete($filepath);
        } catch (BadRequest $e) {
            // No se hace nada
        }

        $client->upload($filepath, file_get_contents($filepath, 'overwrite'));

        $res = $client->createSharedLinkWithSettings($filepath, [
            'requested_visibility' => 'public',
        ]);
        $res['url'][mb_strlen($res['url']) - 1] = '1';
        $this->img = $res['url'];

        return $res;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipoUsuario()
    {
        return $this->hasOne(EquiposUsuarios::className(), ['id' => 'equipo_usuario_id'])->inverseOf('posts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreador()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'creador_id'])->inverseOf('posts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestas()
    {
        return $this->hasMany(Respuestas::className(), ['post_id' => 'id'])->inverseOf('post');
    }
}
