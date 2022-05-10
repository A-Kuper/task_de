<?php

require $_SERVER['DOCUMENT_ROOT'].'/lib/connect.php';


/**
 * @param mysqli $connect
 * @param string|null $newsType
 * @param string|null $newsTitle
 * @param int $offset
 * @return bool|mysqli_result
 */
function getNewsFromNewsPhp(mysqli $connect, ?string $newsType, ?string $newsTitle,  int $offset): mysqli_result
{
    if (is_null($newsType)) {
        $addingSearchByTitleToRequest = "news.title='$newsTitle'";
        $addingSearchByTypeToRequest = ''; //Если тип не указан, то ищем по названию новости
    }elseif(is_null($newsTitle)) {
        $addingSearchByTypeToRequest = "news_type.title='$newsType'";
        $addingSearchByTitleToRequest = ''; //Если название не указано, ищем по типу новости
    }else {
        $addingSearchByTypeToRequest = "news_type.title='$newsType'"; //Если указано название и тип
        $addingSearchByTitleToRequest = " AND news.title='$newsTitle'"; //То накладываем фильтрацию
    }

    $news = mysqli_query($connect, "SELECT SQL_CALC_FOUND_ROWS news.id, news.title as news_title,
                                       news_type.title as news_type
                                       FROM news LEFT JOIN news_type 
                                       ON news.id_news_type=news_type.id
                                       WHERE $addingSearchByTypeToRequest $addingSearchByTitleToRequest
                                       LIMIT ".LIMIT." OFFSET $offset");


    return $news;
}



function getNewsFromIndexPhp(mysqli $connect, int $offset): mysqli_result
{
    $news = mysqli_query($connect, "SELECT SQL_CALC_FOUND_ROWS news.id, news.title as news_title,
                                       news_type.title as news_type
                                       FROM news LEFT JOIN news_type 
                                       ON news.id_news_type=news_type.id
                                       LIMIT ".LIMIT." OFFSET $offset");


    return $news;
}


function countTotalNewsForOutputByFilter(mysqli $connect, ?string $newsType, ?string $newsTitle)
{
    if (is_null($newsType)) {
        $addingSearchByTitleToRequest = "news.title='$newsTitle'";
        $addingSearchByTypeToRequest = ''; //Если тип не указан, то ищем по названию новости
    }elseif(is_null($newsTitle)) {
        $addingSearchByTypeToRequest = "news_type.title='$newsType'";
        $addingSearchByTitleToRequest = ''; //Если название не указано, ищем по типу новости
    }else {
        $addingSearchByTypeToRequest = "news_type.title='$newsType'"; //Если указано название и тип
        $addingSearchByTitleToRequest = " AND news.title='$newsTitle'"; //То накладываем фильтрацию
    }

    $news = mysqli_query($connect, "SELECT COUNT(news.id)
                                       FROM news LEFT JOIN news_type
                                       ON news.id_news_type=news_type.id
                                       WHERE $addingSearchByTypeToRequest $addingSearchByTitleToRequest");



    return mysqli_fetch_array($news, MYSQLI_ASSOC);
}


function countTotalNewsForOutputWithoutFilter(mysqli $connect): array
{
    $news = mysqli_query($connect, "SELECT COUNT(news.id)
                                       FROM news LEFT JOIN news_type
                                       ON news.id_news_type=news_type.id");


    return mysqli_fetch_array($news, MYSQLI_ASSOC);
}




function handleNews(mysqli_result $news): array
{
    $handledNews = [];
    while ($obj = mysqli_fetch_object($news)) {
        $handledNews[$obj->id]['news_title'] = $obj->news_title;
        $handledNews[$obj->id]['news_type'] = $obj->news_type;
    }

    return $handledNews;
}



//$Result=mysqli_query($mysqli,"SELECT SQL_CALC_FOUND_ROWS  id From news LIMIT 10");
//$NORResult=mysqli_query($mysqli,"Select FOUND_ROWS()");
//$NORRow=mysqli_fetch_array($NORResult);
//$NOR=$NORRow["FOUND_ROWS()"];
//
//var_dump($NOR);





