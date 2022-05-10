<?php

require $_SERVER['DOCUMENT_ROOT'].'/config.php';

$mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if(mysqli_connect_errno()){
    return 'Ошибка при подключении к базе данных('.mysqli_connect_errno().' ):'.mysqli_connect_error();
}
