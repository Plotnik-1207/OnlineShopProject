<?php
require_once(__DIR__ . '/../../config/database.php');

function getCategoryById($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $sql->execute([$id]);
    $result = $sql->fetch();
    return $result;
}

function showProduct($id)
{
    $result = getCategoryById($id);
    if (!$result) {
        console_log($result);
        return;
    }

    if ($result) {
        require __DIR__ . '/../../views/product.php';
        console_log($result);
    } else {
        echo "Нет товара по такому id";
    }
}
