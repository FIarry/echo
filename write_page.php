<?php
include 'databasePHP/connect.php';
session_start();
$checkAccount = true; # для отладки
if ($checkAccount) {
    if (isset($_SESSION["login"]) && isset($_SESSION["password"]) && isset($_SESSION["id"])) {
        # повторная проверка аккаунта
        $query = 'SELECT password FROM `users` WHERE id="' . $_SESSION['id'] . '";';
        $func = mysqli_query($conn, $query);
        $row = $func->fetch_assoc();
        if ($func) {
            if ($row['password'] != $_SESSION["password"]) {
                # при неверном пароле отправить на страничку регистрации
                session_destroy();
                session_abort();
                header("Location: login.php");
            }
        } else {
            # при не найденном аккаунте отправить на страничку регистрации
            session_destroy();
            session_abort();
            header("Location: login.php");
        };
    } else {
        # при отсутствии аккаунта отправить на страничку регистрации
        header("Location: login.php");
    }
}
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
        <div class="formContainer">
            <h1 class="writePageTitle">Создать Пост</h1>
            <form class="writeForm" action="databasePHP/create_post.php" method="post">
                <input type="text" name="postName" class="postNameInput" placeholder="Название Поста" required>
                <textarea name="postContent" cols="30" rows="10" class="postContentInput" placeholder="Информация" required></textarea>
                <select name="category" class="postNameInput">
                    <option value="travel">Путешествия</option>
                    <option value="politics">Политика</option>
                    <option value="food">Еда</option>
                    <option value="media">Медиа</option>
                </select>
                <button type="submit" class="postButton">Опубликовать</button>
            </form>
        </div>
    </div>
</body>

</html>