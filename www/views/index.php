<?php
/**
 *  fichier qui génère la vue pour l'url "/"
 * 
 */

// if (isset($_GET['page']) && ((int)$_GET['page'] <= 1) || !is_int((int)$_GET['page']) || is_float($_GET['page'] + 0)) {
//     header('Locaion: /');
//     exit();
// }

$title = "Super Blog";

//$pdo = new PDO('mysql:dbname=blog;host=blog.mysql;charset=UTF8', 'userblog', '123456');

$pdo = new PDO(
    "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);

$nbpost = $pdo->query('SELECT count(id) FROM post')->fetch()[0];
$perPage = 9;
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
//dd($currentPage);
$offset = ($currentPage - 1) * $perPage;

$req = $pdo->query("SELECT * FROM post 
                    ORDER BY id 
                    LIMIT {$perPage} 
                    OFFSET {$offset}")
                    ->fetchAll();

?>
    <section>
        <? foreach ($req as $key => $value) : ?>
        <article>
            <h2><?= 'N°'. $value['id'] . ' -' ?> <?= $value['name'] ?></h2>
            <p><?= substr($value['content'], 0, 200) ?>...</p>
        </article>
        <? endforeach ?>
    </section>
    

    <footer>
        <div>
            <ul class="pagination">
                <?php $classBefore = $currentPage == 1 ? "dnone" : ""; ?>
                <li><a class="<?= $classBefore ?>" href="/?page=<?= ($currentPage - 1) ?>">&laquo;</a></li>

                <? for ($i = 1; $i <= $nbPage; $i++) : ?>
                    <?php $class = $currentPage == $i ? "active" : ""; ?>
                    <? $uri = $i == 1 ? "" : "?page=" . $i; ?>
                    <li><a class="<?= $class ?>" href="/<?= $uri ?>"><?= $i ?></a></li>
                <? endfor ?>

                <?php $classAfter = $currentPage == $nbPage ? "dnone" : ""; ?>
                <li><a class="<?= $classAfter ?>" href="/?page=<?= ($currentPage + 1) ?>">&raquo;</a></li>
            </ul>
        </div>
    </footer>