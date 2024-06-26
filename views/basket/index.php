<?php
/*
 * Страница корзины покупателя, файл views/basket/index.php
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJs(<<<JS
$('.js-input').on('input', function (e) {
    var sum = 0;
    $('.js-product').each(function (i,e) {
         var price = $(e).find('.js-price').html();
         var count = $(e).find('.js-input').val();
         $(e).find('.js-sum').html(price * count);
         sum += parseFloat(price) * count;
    });
    $('.js-sum-all').html(sum);
    
    $.ajax({
        url: '/basket/ajax',
        type: 'post',
        data: {
            id: $(this).data('id'),
            count: $(this).val()
        },
        success: function (data) {
            
        }
    })
});

JS
);

?>

<section>
    <div class="container">
        <div class="row">


            <div class="col-sm-9">
                <h1>Корзина</h1>
                <div id="basket-content">
                    <?php if (!empty($basket)): ?>
                        <p class="text-right">
                            <a href="<?= Url::to(['basket/clear']); ?>" class="text-danger">
                                Очистить корзину
                            </a>
                        </p>
                        <div class="table-responsive">
                            <form action="<?= Url::to(['basket/update']); ?>" method="post">
                                <?=
                                Html::hiddenInput(
                                    Yii::$app->request->csrfParam,
                                    Yii::$app->request->csrfToken
                                );
                                ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Наименование</th>
                                        <th>Кол-во, шт.</th>
                                        <th>Цена, руб.</th>
                                        <th>Сумма, руб.</th>
                                        <th></th>
                                    </tr>
                                    <?php foreach ($basket['products'] as $id => $item): ?>
                                        <tr class="js-product">
                                            <td>
                                                <a href="<?= Url::to(['catalog/product', 'id' => $id]); ?>">
                                                    <?= Html::encode($item['name']); ?>
                                                </a>
                                            </td>
                                            <td class="text-right">
                                                <?= Html::input('text', 'count['.$id.']', $item['count'], [
                                                    'style' => 'width: 100%; text-align: right;',
                                                    'class' => 'js-input',
                                                    'data' => ['id' => $id],
                                                ]);
                                                ?>
                                            </td>
                                            <td class="text-right js-price"><?= $item['price']; ?></td>
                                            <td class="text-right js-sum"><?= $item['price'] * $item['count']; ?></td>
                                            <td>
                                                <a href="<?= Url::to(['basket/remove', 'id' => $id]); ?>" class="text-danger">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td>
                                            <button type="submit"
                                                    class="btn btn-success">
                                                <i class="fa fa-refresh" aria-hidden="true"></i>
                                                Пересчитать
                                            </button>
                                        </td>
                                        <td colspan="2" class="text-right">Итого</td>
                                        <td class="text-right js-sum-all"><?= $basket['amount']; ?></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    <?php else: ?>
                        <p>Ваша корзина пуста</p>
                    <?php endif; ?>
                </div>
                <?php if (!empty($basket)): ?>
                    <a href="<?= Url::to(['order/create']); ?>"
                       class="btn btn-success">
                        Оформить заказ
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
