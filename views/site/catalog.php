<?php

/** @var array $arr_products */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">


        
            <?php foreach ($arr_products as $products): ?>
            <div class="col-lg-4">
                <img src="/web/uploads/<?=$products->photo ?>" width="250" height="270" alt="img">

                <!-- <h2><a href="/web/site/product_details?id=<?=$products->id ?>"><?= $products->name ?> </a></h2> -->    
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
                <h6><div style="width: 250px; word-wrap: break-word;"><?= $products->compound ?></div></h6>
                <h4><p>Цена: <?=$products->price ?> Р</p></h4>
                <?php
                if (!Yii::$app->user->isGuest):
                    echo '
                    <form method="post" action='.Url::to(['basket/add']).'>      
                    <input type="hidden" name="id" value='.$products->id.'>
                    '.Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken).'
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
