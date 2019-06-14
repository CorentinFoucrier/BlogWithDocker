<?php
/**
 *  fichier qui génère la vue pour l'url "/"
 * 
 */

use App\Model\Post;
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

$postById = [];
foreach ($posts as $post) {
    $postById[$post->getId()] = $post;
    $categories = Post::categoriesQuery($post->getId());
    $postById[$post->getId()]->setCategories($categories);
}

?>

    <section class="home">
        <?php /** @var Post::class $post */
        foreach ($posts as $post) {
            $categories = $post->getCategories();
            require 'card.php';
        }
        ?>
    </section>

<?= $paginated->getNavHtml() ?>