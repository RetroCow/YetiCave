<?php
require_once ("functions.php");
require_once ("all_lots.php");

$lots_id = [];
$title = "История просмотров";
$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];

if (isset($_COOKIE['lot_id'])){
    $lots_id = json_decode($_COOKIE['lot_id']);
}

$main_content = get_template("templates/history.php", ['lots' => $lots, 'lots_id' => $lots_id]);
$layout = get_template("templates/layout.php", ['categories' => $categories, 'title' => $title, 'main_content' => $main_content]);

print $layout;

?>