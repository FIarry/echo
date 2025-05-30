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
                    echo '<a href="databasePHP/logout.php" class="accountName">' . $_SESSION["login"] . '</a>';
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
        <div class="commentsContainer">
            <?php
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
                $id = mysqli_real_escape_string($conn, $_GET['id']);
                if (isset($_SESSION["login"])) {
                    echo '
                    <form action="databasePHP/create_comment.php?id=' . $id . '" method="post" class="commentform">
                        <textarea name="comContent" cols="30" rows="3" class="commentinput" placeholder="Комментарий"></textarea>
                        <button type="submit" class="commentsubmit">Опубликовать</button>
                    </form>';
                };
                $query = "SELECT * FROM comments WHERE postID=" . $id . " ORDER BY time DESC";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $query2 = 'SELECT login FROM `users` WHERE id="' . $row['userID'] . '"';
                    $result2 = mysqli_query($conn, $query2);
                    $row2 = mysqli_fetch_assoc($result2);
                    if ($isadmin == 1) {
                        echo '<a href="databasePHP/delete_comment.php?id=' . $row['id'] . '&pid=' . $row['postID'] . '" class="commentContainer">
                        <div class="commentuser">' . $row2['login'] . '</div>
                        <div class="commentcontent">' . $row['content'] . '</div>
                        </a>';
                    } else {
                        echo '<div class="commentContainer">
                        <div class="commentuser">' . $row2['login'] . '</div>
                        <div class="commentcontent">' . $row['content'] . '</div>
                        </div>';
                    }
                };
            };
            ?>
        </div>
    </div>
</body>

</html>