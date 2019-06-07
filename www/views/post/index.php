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

$nbpost = $pdo->query('SELECT count(id) FROM post')->fetch()[0];
$perPage = 6;
$nbPage = ceil($nbpost / $perPage);

if ((int)$_GET['page'] > $nbPage) {
    header('Location: /');
    exit();
}

if (isset($_GET['page'])) {
    $currentPage = (int)$_GET['page'];
} else {
    $currentPage = 1;
}

$offset = ($currentPage - 1) * $perPage;

$statement = $pdo->query("SELECT * FROM post 
                    ORDER BY id 
                    LIMIT {$perPage} 
                    OFFSET {$offset}");
$statement->setFetchMode(PDO::FETCH_CLASS, Post::class);
$posts = $statement->fetchAll();

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

    <nav class="footer">
        <div>
            <ul class="pagination">
                <? $classBefore = $currentPage == 1 ? "dnone" : ""; ?>
                <li class="<?= $classBefore ?>">
                    <? if ($currentPage == 1) { ?>
                        <a>&laquo;</a>
                    <? } else { ?>
                        <a href="/?page=<?= ($currentPage - 1) ?>">&laquo;</a>
                    <? } ?>
                </li>

                <? for ($i = 1; $i <= $nbPage; $i++) : ?>
                    <? $class = $currentPage == $i ? "active" : ""; ?>
                    <? $uri = $i == 1 ? "" : "?page=" . $i; ?>
                    <li><a class="<?= $class ?>" href="/<?= $uri ?>"><?= $i ?></a></li>
                <? endfor ?>

                <? $classAfter = $currentPage == $nbPage ? "dnone" : ""; ?>
                <li class="<?= $classAfter ?>">
                    <? if ($currentPage == $nbPage) { ?>
                        <a>&raquo;</a>
                    <? } else { ?>
                        <a href="/?page=<?= ($currentPage + 1) ?>">&raquo;</a>
                    <? } ?>
                </li>
            </ul>
        </div>
    </nav>