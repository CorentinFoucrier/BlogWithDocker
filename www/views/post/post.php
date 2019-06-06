<?php
/**
 *  fichier qui génère la vue pour l'url "/article/[*:slug]-[i:id]"
 * 
 */

use App\Model\Post;
use App\Connexion;

$id = $params['id'];
$slug = $params['slug'];

$pdo = Connexion::getPdo();

$statement = $pdo->prepare("SELECT * FROM `post` WHERE `id` = ?");
$statement->execute([$id]);
$statement->setFetchMode(PDO::FETCH_CLASS, Post::class);
$post = $statement->fetch();

if (!$post) {
    throw new Exception('Aucun article ne correspond à l\'ID');
}

if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['id'=>$id, 'slug'=>$post->getSlug()]);
    http_response_code(301);
    header('Location: '. $url);
}

$query = $pdo->prepare("
SELECT c.id, c.slug, c.name
FROM post_category pc
JOIN category c ON pc.category_id = c.id
WHERE pc.post_id = :id
");
$query->execute([":id" => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);
/** @var Post|false */
$categories = $query->fetchAll();

$title = $post->getName();

?>
<section class="post">
    <article>

        <h3>
        Catégories: 
        <? foreach ($categories as $key => $category) : 
        if ($key > 0) {
            echo ', ';
        }?>

        <?= $category->getName() ?>
        <? endforeach ?>
        </h3>

        <p><?= nl2br(htmlspecialchars($post->getContent())) ?></p>

        <p>article avec l'id <?= $id . " et le slug " . $slug ?></p>

        <span class="text-muted">Poster le : <?= $post->getCreatedAt() ?></span><br />

    </article>
</section>