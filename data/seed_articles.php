<?php

$articles = json_decode(file_get_contents('./articles.json'), true);

$dns = "mysql:host=127.0.0.1;dbname=T_Blog";
$dbUser = "T_Blog";
$dbPassword = "T_Blog";

$pdo = new PDO($dns, $dbUser, $dbPassword);

$statement = $pdo->prepare(
    'INSERT INTO article (title, category, content, image)
    VALUES (:title, :category, :content, :image)'
);

foreach ($articles as $article) {
    $statement->bindValue("title", $article["title"]);
    $statement->bindValue("category", $article["category"]);
    $statement->bindValue("content", $article["content"]);
    $statement->bindValue("image", $article["image"]);
    $statement->execute();
}
