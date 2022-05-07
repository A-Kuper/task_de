<?php

require_once './mysql.php';

session_start();

if (isset($_GET['search'])) {
    $_SESSION['input_name'] = $_GET['search'];
}else echo 'Введите название новостей для поиска.';

if (isset($_GET['type']) && $_GET['type'] !== 'Выбрать') {
    $_SESSION['selected_type'] = $_GET['type'];

}else $_SESSION['selected_type'] = NULL;

$arr = [];

$news = getNews($_SESSION['input_name'], $mysqli, $_SESSION['selected_type']);
while ($obj = mysqli_fetch_object($news)) {
    $arr[$obj->id]['news_title'] = $obj->news_title;
    $arr[$obj->id]['news_type'] = $obj->news_type;
}


echo '<pre>';
print_r($arr);
echo '</pre>';

