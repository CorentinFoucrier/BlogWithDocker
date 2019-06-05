<?php
/**
 *  fichier qui génère la vue pour l'url "/article/[*:slug]-[i:id]"
 * 
 */

use App\Model\Post;

$id = $params['id'];
$slug = $params['slug'];

$pdo = new PDO(
    "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);

$statement = $pdo->prepare("SELECT * FROM `post` WHERE `id` = ?");
$statement->execute([$id]);
$statement->setFetchMode(PDO::FETCH_CLASS, Post::class);
$post = $statement->fetch();

$article = 'Article : ' . $post->getName();
?>
<section class="post">
    <article>
        <h1><?= $article ?></h1>

        <p><?= nl2br(htmlspecialchars($post->getContent())) ?></p>

        <p>article avec l'id <?= $id . " et le slug " . $slug ?></p>

        <span class="text-muted">Poster le : <?= $post->getCreatedAt() ?></span><br />

    </article>
</section>