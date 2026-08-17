<?php
require_once(__DIR__ . '/../../config/database.php');

function getCategoryByParentId($parent_id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM categories WHERE parent_id = ?');
    $sql->execute([$parent_id]);
    $result = $sql->fetchAll();
    return $result;
}

function showCategories($parent_id)
{
    $result = getCategoryById($parent_id);
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
