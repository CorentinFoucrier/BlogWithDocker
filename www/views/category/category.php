<?php

/**
 *  fichier qui génère la vue pour l'url "/categories/[*:slug]-[i:id]"
 * 
 */

$pdo = new PDO(
    "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);

?>

<p>TEST</p>