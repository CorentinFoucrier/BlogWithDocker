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

$post = $pdo->query("SELECT * FROM `post` WHERE `id` = {$id}")->fetch(\PDO::FETCH_OBJ);
?>
<section class="post">
    <article>
        <h1><?= $post->name ?></h1>

        <p><?= $post->content ?></p>

        <p>article avec l'id <?= $id . " et le slug " . $post->slug ?></p>

        <a href="/"><button>Retour</button></a>
    </article>
</section>