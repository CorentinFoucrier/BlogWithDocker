<?php
/**
 *  fichier qui génère la vue pour l'url "/categories"
 * 
 */

use App\Model\Post;

$pdo = new PDO(
    "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);

$title = "Catégories";
$statement = $pdo->prepare("SELECT * FROM category");
$statement->execute([]);
$statement->setFetchMode(PDO::FETCH_CLASS, Post::class);
$categories = $statement->fetchAll();
//dd($categories);
?>
<nav>
    <ul>
        <? foreach ($categories as $category) : ?>
        <li><a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>"><?= $category->getName() ?></a></li>
        <? endforeach ?>
    </ul>
</nav>
