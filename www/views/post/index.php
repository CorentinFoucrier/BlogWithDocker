<?php
/**
 *  fichier qui génère la vue pour l'url "/"
 * 
 */

use App\Model\Post;
use App\Helpers\Text;
use App\Connexion;

$title = "Super Blog";

$pdo = Connexion::getPdo();

$id = $params['id'];

$uri = $router->url("home");

$paginated = new App\PaginatedQuery(
    "SELECT count(id) FROM post",
    "SELECT * FROM post ORDER BY id",
    Post::class,
    $uri,
    6
);

$posts = $paginated->getItems();

?>

    <section class="home">
        <? foreach ($posts as $post) : ?>
        <article class="homeArticle">
            <h2><?= 'N°'. $post->getId() . ' -' ?> <?= $post->getName() ?></h2>
            <p><?= Text::excerpt($post->getContent()) ?><span class="text-muted">Posté le : <?= $post->getCreatedAt() ?></span></p>
            <div>
                <a class="myButton" href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>">About more...</a>
            </div>
        </article>
        <? endforeach ?>
    </section>

<?= $paginated->getNavHtml() ?>