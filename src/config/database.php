<?php

function connectDatabase()
{
    $host = $_ENV["DB_HOST"] ?? null;
    $dbname = $_ENV["DB_NAME"] ?? null;
    $user = $_ENV["DB_USER"] ?? null;
    $pass = $_ENV["DB_PASS"] ?? null;

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $attributes = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ];
        foreach ($attributes as $attribute => $value) {
            $pdo->setAttribute($attribute, $value);
        }
    } catch (PDOException $e) {
        echo $e;
        return;
    }

    return $pdo;
}
