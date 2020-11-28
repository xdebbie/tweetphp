<?php

namespace Test;

use PDO;

abstract class PDOFactory
{
    public static function getPDO(): PDO
    {
        $pdo = new PDO("mysql:host=localhost;dbname=twitter_test;charset=utf8;port=8889", "root", "root", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);

        return $pdo;
    }
}
