<?php

namespace app\models;

/**
 * This is the model class for table "plantilla".
 *
 * @property int $id
 * @property string $extension
 */
class Plantilla extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantilla';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['extension'], 'required'],
            [['extension'], 'string', 'max' => 255],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'extension' => 'Extension',
        ];
    }
    public function getRuta()
    {
        return 'plantilla/' . $this->id . '.' . $this->extension;
    }
}
