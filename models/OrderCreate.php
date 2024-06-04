<?php
namespace app\models;
use Yii;
class OrderCreate extends Order
{
   public $password_confirm;

    public function rules()
    {
        return [
            [['name_client', 'id_user','password_confirm'], 'required'],
            [['timestamp'], 'safe'],
            [['desmiss'], 'string'],
            ['password_confirm','compare', 'compareValue'=>  Yii::$app->user->identity->password, 'message'=>'Неверный пароль'],
            [['id_user', 'id_status'], 'integer'],
            [['name_client','password_confirm'], 'string', 'max' => 255],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['id_status' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_client' => 'Имя',
            'timestamp' => 'Время',
            'desmiss' => 'Решение',
            'id_user' => 'Id Пользователя',
            'id_status' => 'Id Статуса',
            'password_confirm' => 'Пароль',
        ];
    }
}
