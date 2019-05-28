<?php
require 'vendor/autoload.php';

/* BDD */

$dsn = 'mysql:dbname=blog;host=172.17.0.2;charset=utf8';
$user = 'userblog';
$password = '123456';

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

/* FIN BDD */

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

$faker = Faker\Factory::create('fr_FR'); // apelle de la methode create de la class Factory. Faker\ est un namespace.

// $posts = [];
// $categories = [];

for ($i = 0; $i<50; $i++){
    $pdo->exec("INSERT INTO post SET name='{$faker->sentence()}', 
        slug='{$faker->slug}', 
        content='{$faker->paragraphs(rand(3, 15), true)}', 
        created_at='{$faker->date} {$faker->time}'
    ");
    //$posts = $pdo->lastInsertId();
}

for ($i = 0; $i<50; $i++){
    $pdo->exec("INSERT INTO category SET 
        name='{$faker->words(3, true)}', 
        slug='{$faker->slug}'
    ");
    //$categories = $pdo->lastInsertId();
}

// foreach ($posts as $post) {
//     $randomCategories = $faker->randomElements($categories, round(0, count($categories))); //randomElements($array = array ('a','b','c'), $count = 1) // array('c')
//     foreach ($randomCategories as $category) {
//         $pdo->exec("INSERT INTO post_category SET 
//             post_id={$post}, 
//             category_id=$category}
//         ");
//     }
// }

for ($i = 0; $i<50; $i++){
    $pdo->exec("INSERT INTO post_category SET 
        post_id='{$faker->randomDigitNotNull}', 
        category_id='{$faker->randomDigitNotNull}'
    ");
}

for ($i=0; $i < 50; $i++) { 
    $passwordhash = password_hash($faker->password(), PASSWORD_BCRYPT);
    $pdo->exec("INSERT INTO user SET 
        username='{$faker->userName()}', 
        password='{$passwordhash}'
    ");
}