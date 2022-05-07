<?php

require '../config.php';

$mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if(mysqli_connect_errno()){
    return 'Ошибка при подключении к базе данных('.mysqli_connect_errno().' ):'.mysqli_connect_error();
}



//function getNewsByName($inputName, $newsType = NULL): array{
//
//}

$result = mysqli_query($mysqli, "SELECT news.title as news_name,
                                       news_type.title as news_type
                                       FROM news LEFT JOIN news_type 
                                       ON news.id_news_type=news_type.id
                                       WHERE news_type.title='Новость'");


var_dump($result);