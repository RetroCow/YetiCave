<?php

session_start();
require_once('functions.php');
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

$title = "Вход";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $requred = ['email', 'password', 'name', 'message'];
    $errors = [];

    foreach ($requred as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Заполните поле';
        }
    }

    foreach ($form as $field => $value) {
        if ($field == 'email') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = 'Введите корректный email';
            } elseif ($user = searchUserByEmail($value, $users)) {
                $errors[$field] = 'Данный пользователь уже зарегестрирован';
            }
        } elseif ($field == 'password') {
            if (mb_strlen($value) < 8) {
                $errors[$field] = 'Пароль не может быть короче 8 символов';
            } else {
                $form['password'] = password_hash($form['password'], PASSWORD_DEFAULT);
            }
        } elseif ($field == 'name') {
            if (mb_strlen($value) > 40) {
                $errors[$field] = 'Слишком длинное имя';
            }
        } elseif ($field == 'message') {
            if (mb_strlen($value) > 255) {
                $errors[$field] = 'Слишком длинное поле';
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
        } elseif (empty($errors)) {
            move_uploaded_file($file_name, 'upload/'.$file_path);
            $file_path = 'upload/'.$file_path;
        }
    }

    if (empty($errors)) {
        $sql = 'INSERT INTO users (email, name, password, avatar, reg_date) VALUES (?, ?, ?, ?, NOW())';
        $stmt = db_get_prepare_stmt($connect, $sql, [$form['email'], $form['name'], $form['password'], $file_path]);
        $res = mysqli_stmt_execute($stmt);
        if (!$res) {
            $link_errors[] = mysqli_error($connect);
            print_r($link_errors);
        } else {
            header('Location:login.php');
        }
    } else {
        $main_content = get_template('templates/registration.php', ['errors' => $errors, 'form' => $form]);
    }

} else {
    if (isset($_SESSION['user'])) {
        $main_content = get_template('templates/welcome.php', []);
    } else {
        $main_content = get_template('templates/registration.php', []);
    }
}

$layout = get_template('templates/layout.php', ['categories' => $categories, 'title' => $title, 'main_content' => $main_content]);

print $layout;
