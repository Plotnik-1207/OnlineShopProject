<?php
require_once(__DIR__ . '/../../config/database.php');

function getProductById($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $sql->execute([$id]);
    $result = $sql->fetch();
    return $result;
}

function getProductCategoryByProductId($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $sql->execute([$id]);
    $result = $sql->fetch();
    return $result;
}

function getProductImagesByProductId($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM product_images WHERE product_id = ?');
    $sql->execute([$id]);
    $result = $sql->fetchAll();
    return $result;
}

function getProductVariantsByProductId($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM product_variants WHERE product_id = ?');
    $sql->execute([$id]);
    $result = $sql->fetchAll();
    return $result;
}

function showProduct($id)
{
    $result = getProductById($id);
    if (!$result) {
        console_log($result);
        return;
    }
    $result['category'] = getProductCategoryByProductId($result['category_id']);
    $result['images'] = getProductImagesByProductId($id);
    $result['variants'] = getProductVariantsByProductId($id);

    if ($result) {
        require __DIR__ . '/../../views/product.php';
        console_log($result);
    } else {
        echo "Нет товара по такому id";
    }
}
