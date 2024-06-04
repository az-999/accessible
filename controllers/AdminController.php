<?php

namespace app\controllers;

use yii\web\Controller;

class AdminController extends Controller
{
    public function beforeAction($action)
    {
        if (\Yii::$app->user->isGuest || \Yii::$app->user->identity->role->name == "Клиент")
        {
            $this->redirect('/');
            return false;
        }

        if (!parent::beforeAction($action))
        {
            return false;
        }

        //Кастомный код

        return true; // или false что-бы не запускать действие
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}