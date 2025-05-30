<?php
include 'connect.php';
session_start();
$title = mysqli_real_escape_string($conn, $_POST['postName']);
$content = mysqli_real_escape_string($conn, $_POST['postContent']);
$id = $_SESSION['id'];

$stmt = $conn->prepare("INSERT INTO `posts`(`title`,`content`,`userID`) VALUES (?,?,?)");

$stmt->bind_param('ssi',$title,$content,$id);

if ($stmt->execute()) {
    echo 'Пост опубликован успешно';
    $query = 'SELECT id FROM `posts` WHERE title="' . $title . '" AND content="' . $content . '" AND userID=' . $id . ';';
    $curPostID = mysqli_query($conn,$query);
    $row = $curPostID->fetch_assoc();
    $stmt->close();
    $conn->close();
    header("Location: /proekt/post.php?id=".$row['id']);
} else {
    echo 'Ошибка';
    $stmt->close();
    $conn->close();
    header("Location: /proekt/write_page.php");
};