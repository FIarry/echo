<?php
require "connect.php";
session_start();
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$tasks = [];

$isadmin = 0;
if (isset($_SESSION["login"]) && isset($_SESSION["password"]) && isset($_SESSION["id"])) {
    $query = 'SELECT isadmin FROM `users` WHERE id="' . $_SESSION['id'] . '";';
    $func = mysqli_query($conn, $query);
    $row = $func->fetch_assoc();
    if ($func) {
        $isadmin = $row['isadmin'];
    }
}

while ($row = mysqli_fetch_assoc($result)) {
    $query2 = 'SELECT login FROM `users` WHERE id="' . $row['userID'] . '"';
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_assoc($result2);
    if (isset($row2['login'])) {
        $row['userID'] = $row2['login'];
    } else {
        $row['userID'] = "Deleted User";
    };
    if (strlen($row['content']) > 100) {
        $row['content'] = substr($row['content'], 0, 100) . "...";
    }
    $row['isadmin'] = $isadmin;
    $tasks[] = $row;
};

echo json_encode($tasks);
mysqli_close($conn);
