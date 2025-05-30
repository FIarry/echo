<?php
include 'connect.php';
session_start();
if (isset($_GET['id'])) {
} else {
    header("Location: /echo/index.php");
};
$content = mysqli_real_escape_string($conn, $_POST['comContent']);
$userid = $_SESSION['id'];
$postid = $_GET['id'];

$stmt = $conn->prepare("INSERT INTO `comments`(`content`,`userID`,`postID`) VALUES (?,?,?)");

$stmt->bind_param('sii', $content, $userid, $postid);

if ($stmt->execute()) {
    echo 'Комментарий опубликован успешно';
    $stmt->close();
    $conn->close();
    header("Location: /echo/post.php?id=" . $postid);
} else {
    echo 'Ошибка';
    $stmt->close();
    $conn->close();
    header("Location: /echo/write_page.php");
};
