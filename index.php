<?php

require 'config.php';
require './lib/mysql.php';
require './lib/connect.php';


$page = $_GET['page'] ?? 1;
$offset = LIMIT * ($page - 1);

$totalNews = countTotalNewsForOutputWithoutFilter($mysqli);
$totalPages = round(array_shift($totalNews)/LIMIT, 0);

$news = getNewsFromIndexPhp($mysqli, $offset);
$handledNews = handleNews($news);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Task</title>
</head>
<body>
    <form method="GET" action="/lib/news.php">
        <label>
            <input type="text" name="search" placeholder="Введите имя новсоти">
        </label>
        <select name="type">
            <option value="Не выбрано">Не выбрано...</option>
            <option value="Новость">Новость</option>
            <option value="Статья">Статья</option>
            <option value="Пресс-релиз">Пресс-релиз</option>
            <option value="Объявление">Объявление</option>
        </select>
        <button type="submit">Поиск</button>
    </form>
    <?php
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

    ?>

</body>
</html>