<?php
    session_start();
    if (!isset($_SESSION['user'])) {
      header("Location: index.php", true, 403);
      exit;
    }

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

    $lot = null;
    $title = "Добавить лот";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $lot = $_POST;
        $required = ['message', 'lot_name', 'lot_date', 'category', 'lot_rate', 'lot_step'];
        $errors = [];
        foreach ($required as $field) {
          if (empty($lot[$field])) {
            $errors[$field] = 'Поле не заполнено';
          }
        }
        foreach ($lot as $key => $value) {
          if ($key == 'message') {
            if (strlen($value) >= 300) {
              $errors[$key] = 'Слишком длинный текст';
            }
          } elseif ($key == 'lot_name'){
            if (strlen($value) >= 60) {
              $errors[$key] = 'Слишком длинное наименование';
            }
          } elseif ($key == 'category'){
            if ($value == 'Выберите категорию') {
              $errors[$key] = 'Выберите категорию';
            }
          } elseif ($key == 'lot_rate'){
            if (!filter_var($value, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0)))) {
              $errors[$key] = 'Введите корректное число';
            }
          } elseif ($key == 'lot_step'){
            if (!filter_var($value, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0)))) {
              $errors[$key] = 'Введите корректное число';
            }
          }elseif ($key == 'lot_date'){
            $today_time = time();
            $lot_time = strtotime($lot[$key]);
            $date = date('n-j-Y', strtotime($lot[$key]));
            $date_array = explode("-", $date);
            if ($today_time>=$lot_time) {
              $errors[$key] = 'Введите корректную дату';
            }
            elseif (!checkdate($date_array[0], $date_array[1], $date_array[2])) {
              $errors[$key] = 'Введите корректную дату';
            }
          }
        }
        if(isset($_FILES['file_name'])){
          $file_name = $_FILES['file_name']['tmp_name'];
          $file_path = $_FILES['file_name']['name'];
          $file_size = $_FILES['file_name']['size'];
          if (mime_content_type($file_name) !== 'image/png') {
            $errors['file_name'] = 'Некорректный тип файла';
          } elseif ($file_size > 200000) {
            $errors['file_name'] = 'Слишком большой размер файла';
          } else {
            move_uploaded_file($file_name, 'upload/'.$file_path);
          }
        } else {
          $errors['file_name'] = 'Вы не добавили файл';
        }
        
        if (count($errors)) {
          $main_content = get_template('templates/add.php', ['errors' => $errors, 'lot' => $lot]);
        }else {
          $lot_category = $lot['category'];
          $sql = "SELECT id FROM categories WHERE title = '$lot_category'";
          $result = mysqli_query($connect, $sql);
          if($result) {
            $lot_category = mysqli_fetch_all($result, MYSQLI_NUM);
            $lot_category = $lot_category[0][0];
          } else {
            $link_errors[] = mysqli_error($connect);
          }
          $file_path = 'upload/'.$file_path;
          $sql = 'INSERT INTO lots (create_date, category_id, title, description, img, start_price, price_step, end_date, current_price) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?);';
          $stmt = db_get_prepare_stmt($connect, $sql, [$lot_category, $lot['lot_name'], $lot['message'], $file_path, $lot['lot_rate'], $lot['lot_step'], $lot['lot_date'], $lot['lot_rate']]);
          $res = mysqli_stmt_execute($stmt);
          if($res) {
            $lot_id = mysqli_insert_id($connect);
            header('Location:lot.php?id='.$lot_id);
          }
        }
    } else {
      $main_content = get_template('templates/add.php', []);
    }
    $layout = get_template("templates/layout.php", ['main_content' => $main_content, 'categories' => $categories, 'title' => $title,]);
    print $layout;
?>