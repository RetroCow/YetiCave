<?php 

require_once("functions.php");

session_start();

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
    $sql = 'SELECT `email`, `password`, `name`, `avatar` FROM users';
    $result = mysqli_query($connect, $sql);
    if ($result) {
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

$form = [];
$title = "Вход";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $required = ['email', 'password'];
    $errors = [];

    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = "Поле не заполнено";
        }
    }

    foreach ($form as $key => $value) {
        if ($key == 'email') {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$key] = "Введите ваш e-mail адрес";
                } elseif (!$user = searchUserByEmail($value, $users)) {
                    $errors[$key] = "Данный пользователь не найден";
                }
            }
        if ($key == 'password') {
            if (mb_strlen($value) < 8) {
                $errors[$key] = "Пароль должен быть не меньше 8 символов";
            } elseif (!password_verify($value, $user[$key])) {
                $errors[$key] = "Неверный пароль";
            } else {
                $_SESSION['user'] = $user;
            }
        }
    }
    if (count($errors)) {
        $main_content = get_template("templates/login.php", ['form' => $form, 'errors' => $errors]);
    } else {
        header("location:index.php");
    }

} else {
    if (isset($_SESSION['user'])){
        $main_content = get_template("templates/welcome.php", []);
    } else {
        $main_content = get_template("templates/login.php", []);
    }
}

$layout = get_template("templates/layout.php", ['main_content' => $main_content, 'categories' => $categories, 'title' => $title]);

print $layout;
?>