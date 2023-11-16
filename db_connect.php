<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "posts_comments_db";

$conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);
if ($conn -> connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>