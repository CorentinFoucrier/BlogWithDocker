<?php

/**
 *  fichier qui génère la vue pour l'url "/categories/[*:slug]-[i:id]"
 * 
 */

use App\Model\{Post, Category};
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
SELECT *
FROM post_category pc
JOIN category c ON pc.category_id = c.id
WHERE pc.post_id = :id
");
$query->execute([":id" => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);
$categories = $query->fetchAll();
dd($categories);
?>

<p>TEST</p>