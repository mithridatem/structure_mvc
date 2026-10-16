<?php

namespace App\Database;

class Mysql
{
    public static function connectBdd(): \PDO
    {
        // Creation d'un objet PDO
        return new \PDO(
            'mysql:host=localhost;dbname=poomvc',
            "root",
            "root",
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]
        );
    }
}
