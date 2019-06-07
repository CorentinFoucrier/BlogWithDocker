<?php
/**
 *  fichier qui génère la vue pour l'url "/categories"
 * 
 */

use App\Model\Post;
use App\Connexion;

$pdo = Connexion::getPdo();

$title = "Catégories";
$statement = $pdo->prepare("SELECT * FROM category");
$statement->execute([]);
$statement->setFetchMode(PDO::FETCH_CLASS, Post::class);
$categories = $statement->fetchAll();

?>
<nav>
    <ul>
        <? foreach ($categories as $category) : ?>
        <li><a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>"><?= $category->getName() ?></a></li>
        <? endforeach ?>
    </ul>
</nav>
