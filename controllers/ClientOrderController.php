<?php

namespace app\controllers;

use app\models\ClientOrder;
use app\models\ClientOrderSearch;
use app\models\ClientOrderCreate;
use app\models\ProductsOrder;
use app\models\Basket;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientOrderController implements the CRUD actions for ClientOrder model.
 */
class ClientOrderController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ClientOrder models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientOrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientOrder model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ClientOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ClientOrderCreate();
        $basket = (new Basket())->getBasket();
        $model->name_client = \Yii::$app->user->identity->name;
        $model->id_user = \Yii::$app->user->identity->id;
        $count = 0;
        foreach ($basket['products'] as $item) {
            $count = $count + $item['count'];
        }

        $model->count = $count;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                foreach ($basket['products'] as $product) {
                    $productOrder = new ProductsOrder();
                    $productOrder->id_order = $model->id;
                    $productOrder->id_product = $product['id'];
                    $productOrder->save();
                }
                \Yii::$app->session->set('basket',[]);
                return $this->redirect('/');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'basket'=>$basket
        ]);
    }

    /**
     * Updates an existing ClientOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClientOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClientOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ClientOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientOrder::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
