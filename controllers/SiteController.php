<?php

namespace app\controllers;

use app\models\Basket;
use app\models\Favorite;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\RegForm;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionFavorite()
    {
        return $this->render('favorite');
    }

    /**
     */
    public function actionFavoriteAjax()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) {
            return ['code' => 401];
        }

        $id = Yii::$app->request->post('id');

        if (Favorite::find()->where(['user_id'    => Yii::$app->user->id,'product_id' => $id])->exists()) {
            return ['code' => 201];
        }

        $f = new Favorite([
            'user_id'    => Yii::$app->user->id,
            'product_id' => $id,
        ]);
        $f->save();

        return ['code' => 200];
    }

    /**
     */
    public function actionFavoriteRemove()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) {
            return ['code' => 401];
        }

        $id = Yii::$app->request->post('id');

        $i = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'product_id' => $id])->one();

        if (is_null($i)) {
            return ['code' => 404];
        }

        $i->delete();

        return ['code' => 200];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $products = Product::find()->orderBy(['timestamp' => SORT_DESC])->limit(5)->all();
        return $this->render('about', ['products'=>$products]);
    }
    
    public function actionCatalog()
    {
        $category_id = Yii::$app->request->get('category_id');
        $query = Product::find()->orderBy(['timestamp' => SORT_DESC]);
        if (!is_null($category_id)) {
            if ($category_id) {
                $query->where(['id_category' => $category_id]);
            }
        }
        $arr_products = $query->all();

        return $this->render('catalog', [
            'arr_products' => $arr_products,
            'category_id'  => $category_id,
        ]);
    }


}



