<?php
/**
 *  fichier qui génère la vue pour l'url "/article/[i:id]"
 * 
 */

$id = $params['id'];
$slug = $params['slug'];

$pdo = new PDO(
    "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);

$req = $pdo->query("SELECT * FROM `post` WHERE `id` = {$id}")->fetch();
$nbpost = $pdo->query('SELECT count(id) FROM post')->fetch()[0];
if ($id <= 0 || $id > $nbpost) {
    header('Location: /');
}
?>

<h1><?= $req['name'] ?></h1>
<h2><?= $title ?></h2>

<p><?= $req['content'] ?></p>

<p>article avec l'id <?= $id . " et le slug " . $req['slug'] ?></p>

<a href="/"><button>Retour</button></a>