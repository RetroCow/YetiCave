<?php

session_start();
require_once('functions.php');
$search = $_GET['search'];

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
    if ($search) {
        $sql = "SELECT lots.`id`, lots.`title`, `description`, `img`, `current_price`, categories.`title` as `category` FROM lots JOIN categories ON `category_id` = categories.`id` WHERE MATCH(lots.`title`, lots.`description`) AGAINST (?)";
        $stmt = db_get_prepare_stmt($connect, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

$title = 'Поиск';
$main_content = get_template('templates/search.php', ['lots' => $lots, 'search' => $search]);
$layout = get_template('templates/layout.php', ['main_content' => $main_content, 'categories' => $categories, 'search' => $search, 'title' => $title]);

print($layout);