<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск записей</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <form action="index.php" method="post">
        <input type="text" name="search_text" placeholder="Введите текст комментария" style="width: 250px;">
        <input type="submit" name="submit" value="Найти">
        <a href="loader_script.php" class="btn btn-primary">Скачать данные в базу</a>
    </form>
    <?php
    if (isset($_POST["submit"])) {
        $searchText = trim($_POST["search_text"]);

        require_once "db_connect.php"; // Подключение базы данных
        
        if (strlen($searchText) >= 3) { // Поиск совпадений 
            $sql = "SELECT posts.title, comments.body
            FROM posts INNER JOIN comments ON posts.id = comments.postId 
            WHERE comments.body LIKE '%$searchText%'";
            $result = $conn->query($sql);
            
            echo "<h3>Результаты поиска:</h3>";
            $prevPost = null;
            if ($result) {
                while ($row = $result -> fetch_assoc()) { // Вывод результатов
                    if($row["title"] !== $prevPost){
                        echo "<b>Заголовок поста: </b>" . $row["title"] . "<br>";
                        echo "<b>Комментарий к посту: </b>" . $row["body"] . "<br>";
                        echo "<hr>";
                        $prevPost = $row["title"];
                    }
                }
                if (empty($prevPost)) {
                    echo "Совпадений не найдено";
                }
            }
        } else { 
            echo "Минимальная длина запроса 3 символа";
        }

    }
    ?>
</body>

</html>