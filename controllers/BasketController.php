<?php
namespace app\controllers;

use app\models\Basket;
use Yii;
use yii\web\Controller;

class BasketController extends Controller {
    public function actionIndex() {
        $basket = (new Basket())->getBasket();
        return $this->render('index', ['basket' => $basket]);
    }

    public function actionAdd() {

        $basket = new Basket();

        /*
         * Данные должны приходить методом POST; если это не
         * так — просто показываем корзину
         */
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['basket/index']);
        }

        $data = Yii::$app->request->post();
        if (!isset($data['id'])) {
            return $this->redirect(['basket/index']);
        }
        if (!isset($data['count'])) {
            $data['count'] = 1;
        }

        // добавляем товар в корзину и перенаправляем покупателя
        // на страницу корзины
        $basket->addToBasket($data['id'], $data['count']);

        return $this->redirect(['basket/index']);
    }

    public function actionRemove($id) {
        $basket = new Basket();
        $basket->removeFromBasket($id);
        return $this->redirect(['basket/index']);
    }

    public function actionClear() {
        $basket = new Basket();
        $basket->clearBasket();
        return $this->redirect(['basket/index']);
    }

    public function actionUpdate() {
        $basket = new Basket();

        /*
         * Данные должны приходить методом POST; если это не
         * так — просто показываем корзину
         */
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['basket/index']);
        }

        $data = Yii::$app->request->post();
        if (!isset($data['count'])) {
            return $this->redirect(['basket/index']);
        }
        if (!is_array($data['count'])) {
            return $this->redirect(['basket/index']);
        }

        $basket->updateBasket($data);

        return $this->redirect(['basket/index']);
    }
}
