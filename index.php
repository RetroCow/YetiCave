<?php

require_once ('functions.php');

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';


$lots = [
    $lot1=[
        'name' => '2014 Rossignol District Snowboard',
        'cat' => 'Доски и лыжи',
        'price' => 10999,
        'pic' => "img/lot-1.jpg"
    ],
    $lot2=[
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'cat' => 'Доски и лыжи',
        'price' => '159999',
        'pic' => "img/lot-2.jpg"
    ],
    $lot3=[
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'cat' => 'Крепления',
        'price' => '8000',
        'pic' => "img/lot-3.jpg"
    ],
    $lot4=[
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'cat' => 'Ботинки',
        'price' => '10999',
        'pic' => "img/lot-4.jpg"
    ],
    $lot5=[
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'cat' => 'Одежда',
        'price' => '7500',
        'pic' => "img/lot-5.jpg"
    ],
    $lot6=[
        'name' => 'Маска Oakley Canopy',
        'cat' => 'Разное',
        'price' => '5400',
        'pic' => "img/lot-6.jpg"
    ]
];

$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
$title = 'Yeti Cave';

$main_content = get_template('templates/index.php', ['lots' => $lots]);
$layout = get_template('templates/layout.php', ['categories' => $categories, 'title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'user_avatar' => $user_avatar, 'main_content' => $main_content]);

print $layout;
