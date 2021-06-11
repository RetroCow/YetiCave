<?php
function get_template($path, $data = []) {
    if (is_readable($path)) {
        ob_start();
        extract($data);
        require_once($path);
        return(ob_get_clean());
    }
    else {
        echo "Невозможно загрузить ". $path;
    }
}

function formSum ($amount) {
    $amount = ceil($amount);
    if ($amount>=1000) {
        $form = number_format($amount, 0, ".", " ");
        return ($form . " " . '<b class="rub">р</b>');
    }
}

function lots_time($time) {
    date_default_timezone_set('Europe/Moscow');
    $current_time = time();
    $ts_needed = strtotime($time);
    $ts_diff = $ts_needed - $current_time;
    $hours = floor($ts_diff / 3600);
    $min = floor(($ts_diff % 3600) / 60);
    return "$hours:$min";
}