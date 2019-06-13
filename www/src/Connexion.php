<?php

namespace App;

class Connexion
{
    public static function getPdo() :\PDO
    {
        return new \PDO(
            "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE'),
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASSWORD')
        );
    }
}
