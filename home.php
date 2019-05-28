<?php
require 'assets/includes/_db.php';

$pagination = $pdo->query('SELECT count(id) FROM post')->fetch()[0]/10;

if (null !== $_GET['page'] && intval($_GET['page']) > 0 && $_GET['page'] <= $pagination) {
    $start = 10 * $_GET['page'] -10;
} else {
    if (null !== $_GET['page'] && !inval($_GET['page']) || $_GET['page'] > $pagination) {
        $message = 'Page introuvable !';
    }
    $start = 0;
}

$req = $pdo->query("SELECT * FROM post ORDER BY id LIMIT 10 OFFSET {$start}")->fetchAll();

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
        <? foreach ($req as $key => $value) : ?>
        <article>
            <h2><?= 'N°'. $value['id'] . ' -' ?> <?= $value['name'] ?></h2>
            <p><?= substr($value['content'], 0, 150) ?></p>
        </article>
        <? endforeach ?>
    </section>

    <footer>
        <div>
            <ul>
                <li><a href="/">1</a></li>
                <?php for ($i=2; $i <= $pagination; $i++) : ?>
                <li><a href="/?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor ?>
            </ul>
        </div>
    </footer>
</body>
</html>