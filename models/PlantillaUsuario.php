<?php

namespace app\models;

use Spatie\Dropbox\Exceptions\BadRequest;
use yii\imagine\Image;

/**
 * This is the model class for table "plantilla_usuario".
 *
 * @property int $id
 * @property int $usuario_id
 * @property string $url
 *
 * @property Usuarios $usuario
 */
class PlantillaUsuario extends \yii\db\ActiveRecord
{
    public $img;

    /**
     * Tamaño con el que se guardaran las imagenes.
     * @var int
     */
    public const TAMANO = 400;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantilla_usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'img'], 'required'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'url' => 'Url',
        ];
    }

    /**
     * Simple funcion para llamar a una columna con otro nombre.
     * @return [type] [description]
     */
    public function getRuta()
    {
        return $this->url;
    }

    /**
     * Carga la img en disco y la sube a Dropbox.
     * @return [type] [description]
     */
    public function upload()
    {
        if ($this->img === null) {
            return true;
        }
        $conexion = self::find()->orderBy('id DESC')->one();
        $id = $conexion == null ? 1 : $conexion->id + 1;
        $nombre = getenv('Ruta') . 'plantillaUsuario' . $id . '.' . $this->img->extension;

        $res = $this->img->saveAs($nombre);
        if ($res) {
            Image::thumbnail($nombre, self::TAMANO, null)->save($nombre);
        }
        $client = new \Spatie\Dropbox\Client(getenv('Dropbox'));

        try {
            $client->delete($nombre);
        } catch (BadRequest $e) {
            // No se hace nada
        }
        $client->upload($nombre, file_get_contents($nombre, 'overwrite'));

        $res = $client->createSharedLinkWithSettings($nombre, [
            'requested_visibility' => 'public',
            //'linkType' => 'direct', // or "direct"
        ]);
        $url = $res['url'][mb_strlen($res['url']) - 1] = '1';
        $this->url = $res['url'];

        return $res;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('plantillaUsuarios');
    }
}
