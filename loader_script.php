<?php
require_once "db_connect.php"; // Подключение БД

// Проверка БД на наличие данных
$sql = "SELECT * FROM `posts` WHERE id = 1"; 
$result = mysqli_query($conn, $sql);
$postId = mysqli_fetch_array($result, MYSQLI_ASSOC);

// Загрузка данных в БД
if (!$postId) {
    $postCount = 0;
    $commentCount = 0;

    $jsonPosts = file_get_contents('https://jsonplaceholder.typicode.com/posts'); // Получение json данных
    $arrayPosts = json_decode($jsonPosts, true); // Декодирование json 

    $jsonComments = file_get_contents('https://jsonplaceholder.typicode.com/comments');
    $arrayComments = json_decode($jsonComments, true);

    foreach ($arrayPosts as $post) {
        $stmt = $conn -> prepare("INSERT INTO posts (userId, id, title, body) VALUES (?, ?, ?, ?)");
        $stmt -> bind_param("iiss", $post['userId'], $post['id'], $post['title'], $post['body']);
        $stmt -> execute();
        $postCount += 1;
    }
    foreach ($arrayComments as $comm) {
        $stmt = $conn -> prepare("INSERT INTO comments (postId, id, name, email, body) VALUES (?, ?, ?, ?, ?)");
        $stmt -> bind_param("iisss", $comm['postId'], $comm['id'], $comm['name'], $comm['email'], $comm['body']);
        $stmt -> execute();
        $commentCount += 1;
    }
    $conn -> close();
    echo "Загружено {$postCount} записей и {$commentCount} комментариев";
} else {
    echo "Данные уже загружены в базу";
}
?>