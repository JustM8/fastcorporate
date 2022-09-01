<?php
namespace Classes;

use PDO;

class Db
{
    protected static PDO|null $pdo = null;

    public static function pdo(): PDO
    {
        if (is_null(static::$pdo)) {
            static::$pdo = new PDO(
                'mysql:host=mysql;dbname=tech_task',
                'root',
                'secret',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        return static::$pdo;
    }
}

