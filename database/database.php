<?php

$dns = "mysql:host=127.0.0.1;dbname=T_Blog";
$dbUser = 'T_Blog';
$dbPassword = 'T_Blog';
// $dbUser = getenv('DB_USER');
// $dbPassword = getenv('DB_PASSWORD');

try {
    $pdo = new PDO($dns, $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $error) {
    throw new Exception($e->getMessage());
}

return $pdo;
