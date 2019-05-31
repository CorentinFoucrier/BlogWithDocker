<?php
$basePath = dirname(__dir__) . DIRECTORY_SEPARATOR;

require_once $basePath . 'vendor'. DIRECTORY_SEPARATOR .'autoload.php';

$pdo = new PDO(
    "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);
//create tables
echo "[";
$pdo->exec("CREATE TABLE post (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            content TEXT(650000),
            created_at DATETIME NOT NULL,
            PRIMARY KEY (id)
)");
echo "||";
$pdo->exec("CREATE TABLE category (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            PRIMARY KEY (id)
)");
echo "||";
$pdo->exec("CREATE TABLE user (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            PRIMARY KEY (id)
)");
echo "||";
$pdo->exec("CREATE TABLE post_category (
            post_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            category_id INT UNSIGNED NOT NULL,
            PRIMARY KEY (post_id, category_id),
            CONSTRAINT fk_post
                FOREIGN KEY (post_id)
                REFERENCES post (id)
                ON DELETE CASCADE
                ON UPDATE RESTRICT,
            CONSTRAINT fk_category
                FOREIGN KEY (category_id)
                REFERENCES category (id)
                ON DELETE CASCADE
                ON UPDATE RESTRICT
)");
echo "||";
//vidage table
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
echo "||||||||||||";
$faker = Faker\Factory::create('fr_FR'); // apelle de la methode create de la class Factory. Faker\ est un namespace.
echo "||";
// $posts = [];
// $categories = [];

for ($i = 0; $i < 50; $i++){
    $pdo->exec("INSERT INTO post SET name='{$faker->sentence()}', 
        slug='{$faker->slug}', 
        content='{$faker->paragraphs(rand(3, 15), true)}', 
        created_at='{$faker->date} {$faker->time}'
    ");
    echo "|";
    //$posts = $pdo->lastInsertId();
}

for ($i = 0; $i < 5; $i++){
    $pdo->exec("INSERT INTO category SET 
        name='{$faker->words(3, true)}', 
        slug='{$faker->slug}'
    ");
    echo "|";
    //$categories = $pdo->lastInsertId();
}

// foreach ($posts as $post) {
//     $randomCategories = $faker->randomElements($categories, 2); //randomElements($array = array ('a','b','c'), $count = 1) // array('c')
//     foreach ($randomCategories as $category) {
//         $pdo->exec("INSERT INTO post_category SET 
//             post_id={$post}, 
//             category_id=$category}
//         ");
//     }
// }

// Peut remplacé le foreach.

for ($i = 0; $i < 50; $i++){
    $pdo->exec("INSERT INTO post_category SET 
        post_id='{$faker->randomDigitNotNull}', 
        category_id='{$faker->randomDigitNotNull}'
    ");
    echo "|";
}

$passwordhash = password_hash("admin", PASSWORD_BCRYPT);
echo "||";
$pdo->exec("INSERT INTO user SET 
    username='admin', 
    password='{$passwordhash}'
");
echo "||] \n";