<?php
/**@var $mysqli is variable mysql.php*/


require_once './mysql.php';

session_start();

$arr = [];

if (isset($_GET['type'])) {
    if (($_GET['type']) === 'Не выбрано') {
        if (empty($_GET['search'])) {
            echo 'Выберите название и/или тип новсти для поиска.';
        }else{
            $_SESSION['news_title'] = $_GET['search'];
            $news = getNews($mysqli, NULL, $_SESSION['news_title']);
            $arr = handleNews($news);
        }
    } else {
        $_SESSION['news_type'] = $_GET['type'];
        if (empty($_GET['search'])) {
            $news = getNews($mysqli, $_SESSION['news_type'], NULL);
        }else {
            $_SESSION['news_title'] = $_GET['search'];
            $news = getNews($mysqli, $_SESSION['news_type'], $_SESSION['news_title']);
        }
        $arr = handleNews($news);
    }
}


echo '<pre>';
var_dump($arr);
echo '</pre>';


echo '<pre>';
print_r($_SESSION);
echo '</pre>';