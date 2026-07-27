<?php
require_once(__DIR__ . '/../../config/database.php');

function getProduct($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $sql->execute([$id]);
    $result = $sql->fetch();
    return $result;
}

function getProductCategory($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $sql->execute([$id]);
    $result = $sql->fetch();
    return $result;
}

function getProductImages($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM product_images WHERE product_id = ?');
    $sql->execute([$id]);
    $result = $sql->fetchAll();
    return $result;
}

function getProductVariants($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM product_variants WHERE product_id = ?');
    $sql->execute([$id]);
    $result = $sql->fetchAll();
    return $result;
}

function showProduct($id)
{
    $pdo = connectDatabase();

    $result = getProduct($id);
    $result['category'] = getProductCategory($id);
    $result['images'] = getProductImages($id);
    $result['variants'] = getProductVariants($id);

    if ($result) {
        require __DIR__ . '/../../views/product.php';
        console_log($result);
    } else {
        echo "Нет товара по такому id";
    }
}
