<?php

require './connect.php';


/**
 * @param mysqli $connect
 * @param string|null $newsType
 * @param string|null $newsTitle
 * @return bool|mysqli_result
 */
function getNews(mysqli $connect, ?string $newsType, ?string $newsTitle): mysqli_result
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


    $news = mysqli_query($connect, "SELECT news.id, news.title as news_title,
                                       news_type.title as news_type
                                       FROM news LEFT JOIN news_type 
                                       ON news.id_news_type=news_type.id
                                       WHERE ".$addingSearchByTypeToRequest.$addingSearchByTitleToRequest);
    mysqli_close($connect);

    return $news;

}

function handleNews($news): array
{
    $arr = [];
    while ($obj = mysqli_fetch_object($news)) {
        $arr[$obj->id]['news_title'] = $obj->news_title;
        $arr[$obj->id]['news_type'] = $obj->news_type;
    }
    return $arr;
}





