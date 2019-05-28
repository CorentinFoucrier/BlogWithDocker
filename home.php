<?php
require 'assets/includes/_db.php';

switch ($_GET['page']) {
    case 2:
        $result = $pdo->prepare("SELECT * FROM post LIMIT 10, 10");
        $result->execute([]);
        $article = $result->fetchAll();
        break;
        
    case 3:
        $result = $pdo->prepare("SELECT * FROM post LIMIT 20, 10");
        $result->execute([]);
        $article = $result->fetchAll();
        break;

        
    case 4:
        $result = $pdo->prepare("SELECT * FROM post LIMIT 30, 10");
        $result->execute([]);
        $article = $result->fetchAll();
        break;

    case 5:
        $result = $pdo->prepare("SELECT * FROM post LIMIT 40, 10");
        $result->execute([]);
        $article = $result->fetchAll();
        break;
    
    default:
        $result = $pdo->prepare("SELECT * FROM post LIMIT 10");
        $result->execute([]);
        $article = $result->fetchAll();
        break;
}

// $result = $pdo->prepare("SELECT * FROM post LIMIT 50");
// $result->execute([]);
// $article = $result->fetchAll();
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
            <h2><?= 'N°'. $value['id'] . ' -' ?> <?= $value['name'] ?></h2>
            <p><?= substr($value['content'], 0, 150) ?></p>
            
        </article>
        <? endforeach ?>
    </section>

    <footer>
        <div>
            <ul>
                <li><a href="/">1</a></li>
                <li><a href="/?page=2">2</a></li>
                <li><a href="/?page=3">3</a></li>
                <li><a href="/?page=4">4</a></li>
                <li><a href="/?page=5">5</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>