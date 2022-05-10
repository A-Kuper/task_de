<?php
/**@var $mysqli is variable mysql.php*/

require $_SERVER['DOCUMENT_ROOT'].'/lib/mysql.php';

session_start();

$page = $_GET['page'] ?? 1;
$offset = LIMIT * ($page - 1);

$handledNews = [];
$totalNews = [];

if (isset($_GET['type'])) {
    if (($_GET['type']) === 'Не выбрано') {
        if (empty($_GET['search'])) {
            echo 'Выберите название и/или тип новости для поиска.';
        }else{
            $_SESSION['news_title'] = $_GET['search'];
            $news = getNewsFromNewsPhp($mysqli, NULL, $_SESSION['news_title'], $offset);
            $handledNews = handleNews($news);
            $totalNews = countTotalNewsForOutputByFilter($mysqli, NULL, $_SESSION['news_title']);

        }
    } else {
        $_SESSION['news_type'] = $_GET['type'];
        if (empty($_GET['search'])) {
            $totalNews = countTotalNewsForOutputByFilter($mysqli,  $_SESSION['news_title'], NULL);
            $news = getNewsFromNewsPhp($mysqli, $_SESSION['news_type'], NULL, $offset);
            $totalNews = countTotalNewsForOutputByFilter($mysqli, $_SESSION['news_type'], NULL);

        }else {
            $_SESSION['news_title'] = $_GET['search'];
            $news = getNewsFromNewsPhp($mysqli, $_SESSION['news_title'], $_SESSION['news_type'], $offset);
            $totalNews = countTotalNewsForOutputByFilter($mysqli, $_SESSION['news_title'], $_SESSION['news_type']);
        }
        $handledNews = handleNews($news);
    }
}


echo '<pre>';
print_r($handledNews);
echo '</pre>__________<br>';


var_dump($totalNews);

$totalPages = ceil(array_shift($totalNews)/LIMIT);

echo $totalPages;



//echo '<pre>_________';
//print_r($_SESSION);
//echo '</pre>';