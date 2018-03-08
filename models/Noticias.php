<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

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
    public const PageSize = 2;

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
            //[['created_at'], 'safe'],
            [['titulo', 'img'], 'string', 'max' => 255],
            [['creador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['creador_id' => 'id']],
            [['creador_id'], function ($attribute, $params, $validator) {
                if ($this->creador->role->id != Roles::CREADOR) {
                    $this->addError($attribute, 'Este usuario no puede crear noticias');
                }
            }],
        ];
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
