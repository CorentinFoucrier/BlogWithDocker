<?php

/**
 *  fichier qui génère la vue pour l'url "/categories/[*:slug]-[i:id]"
 * 
 */

use App\Model\{Post, Category};
use App\Helpers\Text;
use App\Connexion;

$id = $params['id'];
$slug = $params['slug'];
$pdo = Connexion::getPdo();

$statement = $pdo->prepare("SELECT * FROM category WHERE id=?");
$statement->execute([$id]);
$statement->setFetchMode(PDO::FETCH_CLASS, Post::class);
/** @var Post|false */
$post = $statement->fetch();

if (!$post) {
    throw new Exception('Aucune categorie ne correspond à cet ID');
}

if ($post->getSlug() !== $slug) {
    $url = $router->url(
        'category',
        [
            'id' => $id,
            'slug' => $post->getSlug()
        ]
    );
    http_response_code(301);
    header('Location: ' . $url);
    exit();
}

$uri = $router->url("category", ["id" => $post->getId(), "slug" => $post->getSlug()]);

$paginated = new App\PaginatedQuery(
    "SELECT count(category_id) FROM post_category WHERE category_id = {$post->getId()}",
    "SELECT p.*
    FROM post p
    JOIN post_category pc ON pc.post_id = p.id
    WHERE pc.category_id = {$post->getId()}
    ORDER BY created_at DESC",
    Post::class,
    $uri,
    6
);
$categories = $paginated->getItems();
//dd($paginated->getItems());
?>

<section class="home">
        <? foreach ($categories as $category) : ?>
        <article class="homeArticle">
            <h2><?= 'N°'. $category->getId() . ' -' ?> <?= $category->getName() ?></h2>
            <p><?= Text::excerpt($category->getContent()) ?><span class="text-muted">Poster le : <?= $category->getCreatedAt() ?></span></p>
            <div>
                <a class="myButton" href="<?= $uri ?>">About more...</a>
            </div>
        </article>
        <? endforeach ?>
</section>