<?php 

session_start();
require_once ('functions.php');

$lot = null;
$lots_cookie = null;

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

if (isset($_GET['id'])) {
    $lot_id = $_GET['id'];
    if (isset($lots[$lot_id])) {
        $lot = $lots[$lot_id];
        if (isset($_COOKIE['lot_id'])) {
          $lots_cookie = json_decode($_COOKIE['lot_id']);
          if (!in_array($lot_id, $lots_cookie)){
            $lots_cookie[] = $lot_id;
          }
        } else {
          $lots_cookie[] = $lot_id;
        }
    }
}

if ($connect) {
  $sql = "SELECT lots.`id`, lots.`title` as `lot_name`, `start_price` as `lot_rate`, `img` as `pic`, categories.`title` as `category` FROM lots JOIN categories ON `category_id` = categories.id WHERE lots.id = $lot_id";
  $result = mysqli_query($connect, $sql);
  if ($result) {
      $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);
  } else {
      $link_errors[] = mysqli_error($connect);
  }
}

$title = $lot[0]['lot_name'];
setcookie('lot_id', json_encode($lots_cookie), strtotime('+30 days'), "/");

if (!$lot) {
    http_response_code(404);
}

$main_content = get_template("templates/lot.php", ['lot' => $lot[0]]);
$layout = get_template("templates/layout.php", ['main_content' => $main_content, 'title' => $title, 'categories' => $categories]);
print $layout;
?>

