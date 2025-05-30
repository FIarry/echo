<?php
include 'connect.php';

$login = mysqli_real_escape_string($conn, $_POST['login']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = "SELECT * FROM users WHERE login='" . $login . "';";
$result = mysqli_query($conn, $query);
$row = $result->fetch_assoc();

if ($row) {
    if ($row['password'] == $password && $row['login'] == $login) {
        session_start();
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
        $_SESSION['id'] = $row['id'];
        $conn->close();
        header("Location: /proekt/index.php");
    } else {
        header("Location: /proekt/login.php");
    }
} else {
    $stmt = $conn->prepare("INSERT INTO `users`(`login`,`password`) VALUES (?,?)");

    $stmt->bind_param('ss', $login, $password);

    if ($stmt->execute()) {
        echo 'Пост опубликован успешно';
        $query = 'SELECT id FROM `users` WHERE login="' . $login . '" AND password="' . $password . '";';
        $curPostID = mysqli_query($conn, $query);
        $row = $curPostID->fetch_assoc();
        session_start();
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
        $_SESSION['id'] = $row['id'];
        $stmt->close();
        $conn->close();
        header("Location: /proekt/index.php");
    } else {
        echo 'Ошибка';
        $stmt->close();
        $conn->close();
        header("Location: /proekt/login.php");
    };
}