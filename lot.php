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
  $sql = "SELECT lots.`id`, `description` as `message`, lots.`title` as `lot_name`, `start_price` as `lot_rate`, `img` as `pic`, categories.`title` as `category`, `price_step` as `lot_step`, `current_price`, `start_price` FROM lots JOIN categories ON `category_id` = categories.id WHERE lots.id = $lot_id";
  $result = mysqli_query($connect, $sql);
  if ($result) {
      $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);
  } else {
      $link_errors[] = mysqli_error($connect);
  }
  $sql = "SELECT `amount`, `date`, users.`name` FROM bids JOIN users ON `user_id` = users.`id` WHERE `lot_id` = '$lot_id'";
  $result = mysqli_query($connect, $sql);
  if ($result) {
    $bids = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $link_errors[] = mysqli_error($connect);
    print_r($link_errors);
}
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $errors = [];
    if (empty($form['cost'])) {
        $errors['cost'] = 'Поле не заполнено';
    } elseif (intval($form['cost']) < intval($lot[0]['lot_step'])) {
        $errors['cost'] = 'Введите корректное значение';
    }
    if (empty($errors)) {
        $name = $_SESSION['user']['email'];
        $sql_id = "SELECT id FROM users WHERE email = '$name'";
        $result = mysqli_query($connect, $sql_id);
        if ($result) {
            $name_id = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $link_errors[] = mysqli_error($connect);
            print_r($link_errors);
        }
        $current_price = $lot[0]['current_price'] + $form['cost'];
        $sql = 'INSERT INTO bids (amount, user_id, lot_id, date) VALUES (?, ?, ?, NOW())';
        $stmt = db_get_prepare_stmt($connect, $sql, [$current_price, $name_id[0]['id'], $lot_id]);
        $res = mysqli_stmt_execute($stmt);
        if (!$res) {
            $link_errors[] = mysqli_error($connect);
            print_r($link_errors);
        }
        $sql = "UPDATE lots SET current_price = (?) WHERE id = '$lot_id'";
        $stmt = db_get_prepare_stmt($connect, $sql, [$current_price]);
        $res = mysqli_stmt_execute($stmt);
        if (!$res) {
            $link_errors[] = mysqli_error($connect);
            print_r($link_errors);
        }
        header("Refresh:0");
    }
}

$title = $lot[0]['lot_name'];
setcookie('lot_id', json_encode($lots_cookie), strtotime('+30 days'), "/");

if (!$lot) {
    http_response_code(404);
}

$main_content = get_template("templates/lot.php", ['lot' => $lot[0], 'bids' => $bids]);
$layout = get_template("templates/layout.php", ['main_content' => $main_content, 'title' => $title, 'categories' => $categories]);
print $layout;