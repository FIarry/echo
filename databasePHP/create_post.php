<?php
include 'connect.php';
session_start();
$title = mysqli_real_escape_string($conn, $_POST['postName']);
$content = mysqli_real_escape_string($conn, $_POST['postContent']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$id = $_SESSION['id'];

$stmt = $conn->prepare("INSERT INTO `posts`(`title`,`content`,`userID`,`category`) VALUES (?,?,?,?)");

$stmt->bind_param('ssis', $title, $content, $id, $category);

if ($stmt->execute()) {
    echo 'Пост опубликован успешно';
    $query = 'SELECT id FROM `posts` WHERE title="' . $title . '" AND content="' . $content . '" AND userID=' . $id . ';';
    $curPostID = mysqli_query($conn, $query);
    $row = $curPostID->fetch_assoc();
    $stmt->close();
    $conn->close();
    header("Location: /echo/post.php?id=" . $row['id']);
} else {
    echo 'Ошибка';
    $stmt->close();
    $conn->close();
    header("Location: /echo/write_page.php");
};
