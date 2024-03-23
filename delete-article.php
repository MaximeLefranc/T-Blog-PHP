<?php
require_once __DIR__ . '/database/database.php';
require_once __DIR__ . '/database/security.php';

$currentUser = isLoggedIn();

if ($currentUser) {
    $articleDB = require_once __DIR__ . '/database/Models/ArticleDB.php';

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($id) {
        $article = $articleDB->fetchOne($id);

        if ($article['author'] === $currentUser['id']) {
            $articleDB->deleteOne($id);
        }
    }
}

header("Location: /");
