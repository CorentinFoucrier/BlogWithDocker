<?php
/**
 *  fichier qui génère la vue pour l'url "/"
 * 
 */

$title = "Super Blog";

$pdo = new PDO(
    "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);

$nbpost = $pdo->query('SELECT count(id) FROM post')->fetch()[0];
$perPage = 6;
$nbPage = ceil($nbpost / $perPage);

if ((int)$_GET['page'] > $nbPage) {
    header('Locaion: /');
    exit();
}

if (isset($_GET['page'])) {
    $currentPage = (int)$_GET['page'];
} else {
    $currentPage = 1;
}

$offset = ($currentPage - 1) * $perPage;

$req = $pdo->query("SELECT * FROM post 
                    ORDER BY id 
                    LIMIT {$perPage} 
                    OFFSET {$offset}")
                    ->fetchAll(\PDO::FETCH_OBJ);

?>
    <section>
        <? foreach ($req as $key => $value) : ?>
        <article>
            <h2><?= 'N°'. $value->id . ' -' ?> <?= $value->name ?></h2>
            <p><?= substr($value->content, 0, 100) ?>...</p>
            <div>
                <a class="myButton" href="/article/<?= $value->slug ?>-<?= $value->id ?>">About more...</a>
            </div>
        </article>
        <? endforeach ?>
    </section>

    <footer>
        <div>
            <ul class="pagination">
                <? $classBefore = $currentPage == 1 ? "dnone" : ""; ?>
                <li class="<?= $classBefore ?>">
                    <? if ($currentPage == 1) { ?>
                        <p>&laquo;</p>
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
                        <p>&raquo;</p>
                    <? } else { ?>
                        <a href="/?page=<?= ($currentPage + 1) ?>">&raquo;</a>
                    <? } ?>
                </li>
            </ul>
        </div>
    </footer>