<?php

use app\models\Favorite;
use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;

$ids = Favorite::find()->select('product_id')->where(['user_id' => Yii::$app->user->id])->column();

$arr_products = Product::find()->where(['id' => $ids])->all();

$this->title = 'Избранное';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('https://code.jquery.com/ui/1.13.2/jquery-ui.js', ['depends' => ['\yii\web\JqueryAsset']]);

$city_list = \app\models\Product::find()->select(['name as value', 'id'])->asArray()->all();
$city_list_json = \yii\helpers\Json::encode($city_list);
$this->registerJs(<<<JS

var availableTags = {$city_list_json};
$( ".js-search" ).autocomplete({
    source: availableTags,
    select: function(event, ui) {
        window.location = '/catalog/product?id=' + ui.item.id;
    }
});
$( ".js-favorite" ).click(function (e){
    
    $.ajax({
        url: '/site/favorite-remove',
        type: 'post',
        data: {
            id: $(this).data('id')
        },
        success: function (data) {
            window.location.reload();
        }
    })
});

$('.js-select').change(function(e) {
    window.location = '/site/catalog?category_id=' + $(this).val();
})

$('.js-rating').click(function(e) {
    $('#exampleModal').css('display', 'block');
});

$('.js-close').click(function(e) {
    $('#exampleModal').css('display', 'none');
});

$('.js-close2').click(function(e) {
    $('#exampleModal2').css('display', 'none');
});

$('[data-bs-toggle="tooltip"]').tooltip();

JS
);


?>
<style>
    .ui-menu-item {
        list-style: none;
        background-color: #fff;
        margin-left: 0px;
        padding-left: 0px;
        list-style-position: initial;
    }
    .ui-helper-hidden-accessible {
        display: none;
    }
</style>
<div class="site-index">

    <div class="body-content">





        <div class="row">


            <?php foreach ($arr_products as $products): ?>
                <div class="col-lg-4">
                    <img src="/uploads/<?= $products->photo ?>" width="250" height="270" alt="img">

                    <!-- <h2><a href="/web/site/product_details?id=<?= $products->id ?>"><?= $products->name ?> </a></h2> -->
                    <style>
                        .bt-k {
                            background-color: rgb(172, 255, 170);
                            color: black;
                            transition: 0.3s;
                        }

                        .bt-k:hover {
                            background-color: rgb(100, 163, 99);
                            color: white;
                        }
                    </style>

                    <h2><?= $products->name ?></h2>
                    <h6>
                        <div style="width: 250px; word-wrap: break-word;"><?= $products->compound ?></div>
                    </h6>
                    <h4><p>Цена: <?= $products->price ?> Р</p></h4>

                    <div class="btn-group btn-group-xs" role="group" aria-label="..." style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline-primary js-rating"  data-bs-toggle="tooltip" data-bs-title="Поставить рейтинг 1">1</button>
                        <button type="button" class="btn btn-outline-primary js-rating" data-bs-toggle="tooltip" data-bs-title="Поставить рейтинг 2">2</button>
                        <button type="button" class="btn btn-outline-primary js-rating" data-bs-toggle="tooltip" data-bs-title="Поставить рейтинг 3">3</button>
                        <button type="button" class="btn btn-outline-primary js-rating" data-bs-toggle="tooltip" data-bs-title="Поставить рейтинг 4">4</button>
                        <button type="button" class="btn btn-outline-primary js-rating" data-bs-toggle="tooltip" data-bs-title="Поставить рейтинг 5">5</button>
                    </div>

                    <?php
                    if (!Yii::$app->user->isGuest):
                        echo '
                    <form method="post" action=' . Url::to(['basket/add']) . '>      
                    <input type="hidden" name="id" value=' . $products->id . '>
                    ' . Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) . '
                    <button type="submit" class="bt-k">Добавить в корзину</button>
                    </form>
                    ';
                    endif;
                    ?>
                    <button data-id="<?= $products->id ?>" class="bt-k js-favorite">Убрать из избранного</button>

                </div>
            <?php endforeach; ?>

            
        
        </div>

    </div>
</div>



<div class="modal"  id="exampleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Учет рейтинга</h5>
                <button type="button" class="btn-close js-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Благодарим вас. Ваш рейтинг учтен.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal"  id="exampleModal2" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Избранное</h5>
                <button type="button" class="btn-close js-close2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Товар удален из избранного.</p>
            </div>
        </div>
    </div>
</div>