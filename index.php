<?php
$filename = __DIR__ . '/data/articles.json';
$articles = [];
$categories = [];

if (file_exists($filename)) {
    $articles = json_decode(file_get_contents($filename), true);
    $cattmp = array_map(fn ($article) => $article["category"], $articles);
    $categories = array_reduce($cattmp, function ($acc, $category) {
        if (isset($acc[$category])) {
            $acc[$category]++;
        } else {
            $acc[$category] = 1;
        }
        return $acc;
    }, []);
    $artcilePerCategories = array_reduce($articles, function ($acc, $article) {
        if (isset($acc[$article["category"]])) {
            $acc[$article["category"]] = [...$acc[$article["category"]], $article];
        } else {
            $acc[$article["category"]] = [$article];
        }
        return $acc;
    }, []);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="./public/css/index.css">
    <title>Blog</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="category-container">
                <?php foreach ($categories as $category => $num) : ?>
                    <h2><?= $category ?></h2>
                    <div class="articles-container">
                        <?php foreach ($artcilePerCategories[$category] as $article) : ?>
                            <div class="article block">
                                <div class="overflow">
                                    <div class="img-container" style="background-image: url(<?= $article["image"] ?>);"></div>
                                </div>
                                <h3><?= $article["title"] ?></h3>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>

</body>

</html>