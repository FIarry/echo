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
        <div class="pageContainer">
            <a href="index.php" class="backBtn">Обратно</a>
            <?php
            if (isset($_GET['id'])) {
                $id = mysqli_real_escape_string($conn, $_GET['id']);
                $query = "SELECT * FROM posts WHERE id=" . $id;
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $query2 = 'SELECT login FROM `users` WHERE id="' . $row['userID'] . '"';
                    $result2 = mysqli_query($conn, $query2);
                    $row2 = mysqli_fetch_assoc($result2);
                    if (isset($row2['login'])) {
                        $row['userID'] = $row2['login'];
                    } else {
                        $row['userID'] = "Deleted User";
                    };
                    echo '      
                <div class="pageTitle">' . $row['title'] . '</div>
                <div class="pageAuthor">' . $row['userID'] . '</div>
                <div class="pageAuthor">' . $row['created_at'] . '</div>
                <div class="pageContent">' . $row['content'] . '</div>';
                };
            } else {
                echo "Данная страница не найдена";
            };
            ?>
        </div>
    </div>
</body>

</html>