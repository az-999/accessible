<?php

/** @var yii\web\View $this */
/** @var array $products */

use yii\bootstrap5\Carousel;
use yii\helpers\Html;

$this->title = 'My Yii Application';

// $carouselItems = [];
// foreach($products as $product)
// {
//     $carouselItems[] = [
//         'content' => '<img src="/web/uploads/'. $product->photo .'".>',
//         'caption' =>'<h4>' . $product->name . '</h4><p>' . $product->price .'</p>',
//         'captionOptions' => ['class' => ['d-none', 'd-md-block']],
//         'options' => [],
//     ];
// }

?>
<style>
    .mapp {
        position: relative;
        top: 13px;
        left: 80px;
    }
</style>


<div class="site-index">


    <div class="body-content">
    <h1 style="text-align: center;">Добрый день!</h1>
    <hr>
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <div class="bacimg">
            <button class="btn-ma" onclick="document.location = 'site/about'">Узнать о нас</button>
        </div>
    </div>
    <hr>
    <div style="background-color: rgb(172, 255, 170); padding-bottom: 20px; color: white; display: flex;">
    <iframe class="mapp" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2315.986085742328!2d36.24393761241827!3d54.51610677253751!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4134ba32584980e5%3A0x122f81a9ffad7173!2z0KLQoNCaINCa0LDQu9GD0LPQsCBYWEkg0JLQtdC6!5e0!3m2!1sru!2sru!4v1705792154508!5m2!1sru!2sru" width="600" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <div style="position: relative; left: 200px; top: 40px; color: black;">
        <p>
    <h1> 8 910 500 10 10</h1>
        <h style="font-size: 14px">Ежедневно 10:00-19:00. Звонок бесплатно</h>
        <p>
        <p>
        <hr>
        <h>Пишите нам</h></br>
        <h>accessible@mail.ru</h>
        <p>
        <p>
        <h>Рабочие дни:</h></br>
        <h>Понедельник - Суббота: 9:00 - 21:00</h></br>
        <h>Воскресенье - выходной</h>
    </div>
    </div>  

    </div>
</div>
