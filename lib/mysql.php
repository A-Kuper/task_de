<?php

require './connect.php';




function getNews(string $inputName, object $connect, $newsType): object{
    $addingToRequest = '';

    if (!is_null($newsType)) {
        $addingToRequest = " AND news_type.title='$newsType'";
    }

    $news = mysqli_query($connect, "SELECT news.id, news.title as news_title,
                                       news_type.title as news_type
                                       FROM news LEFT JOIN news_type 
                                       ON news.id_news_type=news_type.id
                                       WHERE news.title='$inputName'".$addingToRequest);
    mysqli_close($connect);
    return $news;

}



