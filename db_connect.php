<?php

$host = "localhost";

$password = "*H9s&+nZGt?\_7_U";

$username = "id18635769_psharipov_db_username";

$databasename = "id18635769_psharipov_db_name";

global  $db;

setlocale(LC_ALL, "ru_RU.UTF8");

$db = new mysqli($host, $username, $password, $databasename, 3306);

if ($db->connect_errno){
    echo " Не удалось подключиться к MySQL";
    exit;
}




