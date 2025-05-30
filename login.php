<?php 
include 'databasePHP/connect.php'; 
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="leftSide">
                <a href="index.php" class="websiteIconContainer">
                        <img src="img/echoicon.png" alt="" class="websiteIcon">
                </a>
                <a href="index.php" class="websiteTitle">Echo Forum</a>
                <a href="write_page.php" class="createPostButton">Создать Пост</a>
            </div>
            <div class="rightSide">
                <?php
                    if (isset($_SESSION["login"])) {
                        echo '<a href="databasePHP/logout.php" class="accountName">'.$_SESSION["login"].'</a>';
                    } else {
                        echo '<a href="login.php" class="loginButton">Войти в Аккаунт</a>';
                    };
                ?>
            </div>
        </div>
        <div class="loginContainer">
            <h1>Войти в аккаунт / Зарегистрировать аккаунт</h1>
            <form action="databasePHP/account.php" class="loginForm" method="post">
                <input type="text" class="loginInput" name="login" placeholder="Логин" required>
                <input type="text" class="loginInput" name="password" placeholder="Пароль" required>
                <button type="submit" class="loginBtn">Войти / Зарегистрироваться</button>
            </form>
        </div>
    </div>
</body>
</html>