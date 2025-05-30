<?php
require 'connect.php';
session_start();

if (isset($_GET['id'])) {
    $isadmin = 0;
    if (isset($_SESSION["login"]) && isset($_SESSION["password"]) && isset($_SESSION["id"])) {
        $query = 'SELECT isadmin FROM `users` WHERE id="' . $_SESSION['id'] . '";';
        $func = mysqli_query($conn, $query);
        $row = $func->fetch_assoc();
        if ($func) {
            $isadmin = $row['isadmin'];
        }
    }
    if ($isadmin == 1) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "DELETE FROM comments WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
    }
    header("Location: /echo/post.php?id=" . $_GET['pid']);
};

mysqli_close($conn);
