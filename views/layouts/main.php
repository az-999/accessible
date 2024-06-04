<?php

/** @var yii\web\View $this */
/** @var string $content */


use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">




<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100", style="background-color: #FFFFFF;">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/uploads/logo.png', ['class' => 'myLogo', 'alt' => 'logo', 'height' => 40]),
        //'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        // 'options' => ['class' => 'navbar-expand-md navbar-dark bg-black fixed-top ' ]
        'options' => ['style' => 'background-color: #ff0000;']
        // 'options' => ['style' => 'background-image: url("./web/uploads/eda21.jpg");
        // background-repeat: no-repeat;
        // background-size: cover;']
    ]);
    $items = [];    
    if (Yii::$app->user->isGuest){
        $items[]=['label' => 'Каталог', 'url' => ['/site/catalog']];
        $items[]=['label' => 'О площадке', 'url' => ['/site/about']];
        $items[]=['label' => 'Логин', 'url' => ['/site/login']];
        $items[]=['label' => 'Регистрация', 'url' => ['/user/create']];
    }
    else
    {
        if (Yii::$app->user->identity->role->name == 'Администратор')
        {
            $items[]=['label' => 'Каталог', 'url' => ['/site/catalog']];
            $items[]=['label' => 'О площадке', 'url' => ['/site/about']];
            $items[]=['label' => 'Административная панель', 'url' => ['/admin']];
        }
        else
        {
            $items[]=['label' => 'Каталог', 'url' => ['/site/catalog']];
            $items[]=['label' => 'О площадке', 'url' => ['/site/about']];
            $items[]=['label' => 'Корзина', 'url' => ['/basket']];
            $items[]=['label' => 'Личный кабинет', 'url' => ['/lk']];
        }
        $items[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->name . ')',
                ['class' => 'nav-link btn btn-link logout'])
            . Html::endForm()
            .'</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $items
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
