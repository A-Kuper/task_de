<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Task</title>
</head>
<body>

<?php
/**@var $mysqli is variable from mysql.php*/

require $_SERVER['DOCUMENT_ROOT'].'/lib/mysql.php';


$page = $_GET['page'] ?? 1;
$offset = LIMIT * ($page - 1);

$handledNews = [];
$totalNews = [];


/**
 * Смотрим, что ввел пользователь и отдаем подходящий под запрос ответ
 */

if (isset($_GET['type'])) {
    if (($_GET['type']) === 'Не выбрано') {
        if (empty($_GET['search'])) {
            echo 'Выберите название и/или тип новости для поиска.';
        }else{
            $news = getNewsFromNewsPhp($mysqli, NULL, $_GET['search'], $offset);
            $handledNews = handleNews($news);
            $totalNews = countTotalNewsForOutputByFilter($mysqli, NULL, $_GET['search']);

        }
    } else {
        if (empty($_GET['search'])) {
            $totalNews = countTotalNewsForOutputByFilter($mysqli,  $_GET['type'], NULL);
            $news = getNewsFromNewsPhp($mysqli, $_GET['type'], NULL, $offset);

        }else {
            $news = getNewsFromNewsPhp($mysqli, $_GET['type'], $_GET['search'], $offset);
            $totalNews = countTotalNewsForOutputByFilter($mysqli, $_GET['type'], $_GET['search']);
        }
        $handledNews = handleNews($news);
    }
}


foreach ($handledNews as $key => $value) { ?>
    <div class="border">
        <?php
        echo "Новость №: {$key};<br> 
              Название новости: {$value['news_title']};<br> 
              Тип новости: {$value['news_type']}. ";
        ?>
        </div><br/>
    <?php
    }

$totalPages = ceil(array_shift($totalNews)/LIMIT);

for($i = 1; $i < $totalPages+1; $i++){
    echo "<a href='news.php?&search=".$_GET['search']."&type=".$_GET['type']."&page=$i'>$i </a>";
}

?>
</body>
</html>



