<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? 'Mon site' ?></title>
</head>

<body>
    <h1><?= $title ?? 'hello' ?></h1>
    <?= $content; ?>
</body>

</html>