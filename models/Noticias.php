<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\imagine\Image;

/**
 * This is the model class for table "noticias".
 *
 * @property int $id
 * @property string $titulo
 * @property string $texto
 * @property string $img
 * @property int $creador_id
 * @property string $created_at
 *
 * @property Usuarios $creador
 */
class Noticias extends \yii\db\ActiveRecord
{
    public const PageSize = 4;

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
            [['texto'], 'string'],
            [['creador_id'], 'default', 'value' => null],
            [['creador_id'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['img'], 'file'],
            [['creador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['creador_id' => 'id']],
            [['creador_id'], function ($attribute, $params, $validator) {
                if (!$this->creador->isCreador()) {
                    $this->addError($attribute, 'Este usuario no puede crear noticias');
                }
            }],
        ];
    }
    public function upload()
    {
        if ($this->img === null) {
            return true;
        }
        $nombre = Yii::getAlias('@uploads/') . $this->id . '.jpg';
        $res = $this->img->saveAs($nombre);
        if ($res) {
            Image::thumbnail($nombre, 300, null)->save($nombre);
        }
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
