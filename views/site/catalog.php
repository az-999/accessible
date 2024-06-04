<?php

/** @var array $arr_products */
/** @var integer | null $category_id */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Каталог';
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

$('.js-select').change(function(e) {
    window.location = '/site/catalog?category_id=' + $(this).val();
})

JS
);


?>
<style>
    .ui-menu-item-wrapper {
        list-style: none;
    }
    .ui-helper-hidden-accessible {
        display: none;
    }
</style>
<div class="site-index">

    <div class="body-content">

        <div class="row">

            <div class="col-lg-6" style="margin-bottom: 20px;">
                <input class="form-control js-search">
            </div>
            <div class="col-lg-6" style="margin-bottom: 20px;">
                <select class="form-control js-select">
                    <option value="">Ничего не выбрано</option>
                    <?php foreach (\app\models\Category::find()->all() as $category) { ?>
                        <option value="<?= $category->id ?>" <?= $category->id == $category_id ? 'selected' : '' ?>><?= $category->name ?></option>
                    <?php } ?>
                </select>
            </div>

        
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
                </div>
            <?php endforeach; ?>

            
        
        </div>

    </div>
</div>
