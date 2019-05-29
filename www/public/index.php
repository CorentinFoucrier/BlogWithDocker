<?php
$basePath = dirname(__dir__) . DIRECTORY_SEPARATOR;

require_once $basePath . 'vendor/autoload.php'; //output: /var/www/vendor/autoload.php

$router = new App\Router($basePath . 'views');

$router->get('/', 'index', 'home')
    ->get('/categories', 'categories', 'categories')
    ->get('/artcle/[i:id]', 'post', 'post')
    ->run();