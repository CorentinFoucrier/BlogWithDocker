<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ? 'Mon site | ' . $title : 'Mon site' ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $_SERVER['REQUEST_SCHEME']. '://' . $_SERVER['HTTP_HOST'] ?>/assets/css/style.css">
    
</head>

<body>
    <header>
        <nav class="navigation">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/categories">Categories</a></li>
            </ul>
        </nav>
        <h1><?= $title ?? 'hello' ?></h1>
        <div>
            <input type="search" name="search" id="search" />
            <input type="submit" value="Rechercher" id="submit"/>
        </div>
    </header>
    <main class="container">
        <?= $content; ?>
    </main>

    <footer>
        <div>
        <?php
            $generationTime = "";
            if (getenv('ENV_DEV')) :
                $end = microtime(true);
                $generationTime = number_format(($end - GENERATE_TIME_START) * 1000, 2);
            ?>
            <span>Page générée en <?= $generationTime ?>ms</span>
            <?php endif ?>
        </div>
    </footer>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="<?= $_SERVER['REQUEST_SCHEME']. '://' . $_SERVER['HTTP_HOST'] ?>/assets/js/script.js"></script>
</body>

</html>