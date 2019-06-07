<?php
define("GENERATE_TIME_START", microtime(true));
$basePath = dirname(__dir__) . DIRECTORY_SEPARATOR;

require_once $basePath . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'; //output: /var/www/vendor/autoload.php

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if (isset($_GET["page"]) && ((int)$_GET["page"] <= 1 || !is_int((int)$_GET["page"]) || is_float($_GET["page"] + 0))) {
    if ((int)$_GET['page'] == 1) {
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        $get = $_GET;
        unset($get['page']);
        $query = http_build_query($get);
        if (!empty($query)) {
            $uri = $uri . '?' . $query;
        }
        http_response_code(301);
        header('Location: ' . $uri);
        exit();
    } else {
        throw New Exception('No page non valide !');
    }
}

$router = new App\Router($basePath . 'views');

$router->get('/', 'post/index', 'home')
    ->get('/categories', 'category/index', 'categories')
    ->get('/category/[*:slug]-[i:id]', 'category/show', 'category')
    ->get('/article/[*:slug]-[i:id]', 'post/show', 'post')
    ->run();