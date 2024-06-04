<?php

namespace app\models;

use Yii;


class Product extends \yii\db\ActiveRecord
{
    
    public function rules()
    {
        return [
            [['name', 'photo', 'price', 'compound', 'id_category'], 'required', 'message'=>'Поле не должно быть пустым'],
            [['price'], 'number'],
            [['timestamp'], 'safe'],
            ['photo', 'file', 'extensions' => 'png, jpg, jpeg, bmp', 'maxSize' => 10*1024*1024],
            [['id_category'], 'integer'],
            [['name', 'photo', 'compound'], 'string', 'max' => 255],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['id_category' => 'id']],
        ];
    }

}
