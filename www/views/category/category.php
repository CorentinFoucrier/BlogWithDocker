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

$statement = $pdo->prepare("SELECT * FROM post WHERE id = ?");
$statement->execute([$id]);
$statement->setFetchMode(PDO::FETCH_CLASS, Post::class);
$post = $statement->fetch();
// SELECT * FROM 'tableA' JOIN 'tableB' ON 'tableA.colone' = 'tableB.colone';
$query = $pdo->prepare("
SELECT p.id, p.name, p.slug, p.content, p.created_at
FROM post_category pc
JOIN post p ON pc.post_id = p.id
WHERE pc.category_id = :id
");
$query->execute([":id" => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);
$categories = $query->fetchAll();

?>

<section class="home">
        <? foreach ($categories as $category) : ?>
        <article class="homeArticle">
            <h2><?= 'N°'. $category->getId() . ' -' ?> <?= $category->getName() ?></h2>
            <p><?= Text::excerpt($category->getContent()) ?><span class="text-muted">Poster le : <?= $category->getCreatedAt() ?></span></p>
            <div>
                <a class="myButton" href="<?= $router->url('post', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>">About more...</a>
            </div>
        </article>
        <? endforeach ?>
</section>