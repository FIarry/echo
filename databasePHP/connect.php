<?php
# подключение к датабазе
$host = 'localhost';
$user = 'root';
$pass = 'mysql';
$db = 'echodb';

$conn = new mysqli($host,$user,$pass,$db);
if ($conn->connect_error) {
    die();
};