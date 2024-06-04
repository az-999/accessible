<?php

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name_client',
            'timestamp',
            'dismiss:ntext',
            'count',
            [
                'attribute' => 'id_status',
                'value'=>'status.name'
            ],
            //'id_user',
            //'id_status',
            [
                'class' => ActionColumn::className(),
                'template'=>'{delete}',
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        return $model->id_status === 1; // Show the delete button if id_status is 'new'
                    }
                ],
                /*'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }*/
            ],
        ],
    ]); ?>


</div>
