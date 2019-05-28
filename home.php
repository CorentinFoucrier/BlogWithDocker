<?php
require 'assets/includes/_db.php';

$result = $pdo->prepare("SELECT * FROM post LIMIT 50");
$result->execute([]);
$article = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Super Blog</h1>
    </header>

    <section>
        <? foreach ($article as $key => $value) : ?>
        <article>
            <h2><?= $value['name'] ?></h2>
            <p><?= substr($value['content'], 0, 150) ?></p>
        </article>
        <? endforeach ?>
    </section>

    <footer>
        <div>
            <ul>
                <li><a href="">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">4</a></li>
                <li><a href="">5</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>