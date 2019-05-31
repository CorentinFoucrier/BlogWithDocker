<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ? 'Mon site | ' . $title : 'Mon site' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <h1><?= $title ?? 'hello' ?></h1>
    </header>
    <?= $content; ?>
</body>

</html>