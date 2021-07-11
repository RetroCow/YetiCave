<?php
session_start();
require_once ('functions.php');

$connect = mysqli_connect('localhost', 'root', '', 'yeti_cave');
if (!$connect) {
    $link_errors[] = mysqli_connect_error();
    print_r($link_errors);
} else {
    $sql = 'SELECT `title` FROM categories';
    $result = mysqli_query($connect, $sql);
    if($result) {
        $cats = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach($cats as $cat) {
            foreach ($cat as $name => $value) {
                $categories[] = $value;
            }
        }
    } else {
        $link_errors[] = mysqli_error($connect);
    }
}

if ($connect) {
    $sql = 'SELECT lots.`id`, lots.`title` as `lot_name`, `start_price` as `lot_rate`, `img` as `pic`, categories.`title` as `category` FROM lots JOIN categories ON `category_id` = categories.id ORDER BY create_date DESC';
    $result = mysqli_query($connect, $sql);
    if ($result) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $link_errors[] = mysqli_error($connect);
    }
}

$title = "YetiCave";

$main_content = get_template('templates/index.php', ['lots' => $lots]);
$layout = get_template('templates/layout.php', ['categories' => $categories, 'title' => $title, 'main_content' => $main_content]);

print $layout;