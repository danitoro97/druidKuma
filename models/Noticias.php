<?php

namespace app\models;

use Spatie\Dropbox\Exceptions\BadRequest;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\imagine\Image;

/**
 * This is the model class for table "noticias".
 *
 * @property int $id
 * @property string $titulo
 * @property string $subtitulo
 * @property string $texto
 * @property string $img
 * @property int $creador_id
 * @property string $created_at
 *
 * @property Usuarios $creador
 */
class Noticias extends \yii\db\ActiveRecord
{
    public $extension;
    /**
     * Numeros de noticias por pagina.
     * @var int
     */
    public const PAGESIZE = 4;

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
        return 'noticias';
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
            [['titulo', 'texto'], 'required'],
            [['texto', 'subtitulo'], 'string'],
            [['creador_id'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['creador_id'], 'required'],
            [['img'], 'file'],
            [['creador_id'], 'default', 'value' => Yii::$app->user->identity->id],
            [['creador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['creador_id' => 'id']],
            [['creador_id'], function ($attribute, $params, $validator) {
                if (!$this->creador->isCreador()) {
                    $this->addError($attribute, 'Este usuario no puede crear noticias');
                }
            }],
        ];
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
        //    $nombre = Yii::getAlias('uploads/') . "a.$this->extension";

        $res = $this->img->saveAs('@uploads/' . ".$this->extension");
        if ($res) {
            Image::thumbnail($nombre, self::TAMANO, null)->save($nombre);
        }
        $client = new \Spatie\Dropbox\Client(getenv('Dropbox'));
        $nombre = ".$this->extension";
        try {
            $client->delete($nombre);
        } catch (BadRequest $e) {
            // No se hace nada
        }
        $client->upload($nombre, file_get_contents(Yii::getAlias("@uploads/$nombre")), 'overwrite');
        $res = $client->createSharedLinkWithSettings($nombre, [
            'requested_visibility' => 'public',
        ]);
        $url = $res['url'][mb_strlen($res['url']) - 1] = '1';
        $this->img = $res['url'];
        return $res;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'texto' => 'Texto',
            'img' => 'Img',
            'creador_id' => 'Creador ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreador()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'creador_id'])->inverseOf('noticias');
    }
}
