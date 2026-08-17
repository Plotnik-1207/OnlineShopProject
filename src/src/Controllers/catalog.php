<?php
require_once(__DIR__ . '/../../config/database.php');

function catalogHandle($id)
{
    if (is_null($id) or isCategoryHasChildren($id)) {
        showCategoriesByParentId($id);
    } else {
        showProductsByCategoryId($id);
    }
}

function isCategoryHasChildren($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM categories WHERE parent_id = ?');
    $sql->execute([$id]);
    $result = $sql->fetchAll();
    return !empty($result);
}

function getCategoryById($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $sql->execute([$id]);
    $result = $sql->fetch();
    return $result;
}

function getProductsByCategoryId($id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT p.id, p.name, pi.img_url, MIN(pv.price) AS min_price
                        FROM products p
                        JOIN product_variants pv ON pv.product_id = p.id
                        JOIN product_images pi ON pi.product_id = p.id
                        WHERE p.category_id = ? AND pi.is_main = 1
                        GROUP BY p.id, p.name, pi.img_url;');
    $sql->execute([$id]);
    $result = $sql->fetchAll();
    return $result;
}

function getCategoryByParentId($parent_id)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT * FROM categories WHERE parent_id = ?');
    $sql->execute([$parent_id]);
    $result = $sql->fetchAll();
    return $result;
}

function showProductsByCategoryId($id)
{
    $result = getProductsByCategoryId($id);
    $category = getCategoryById($id)['name'];

    if (!$result and !$category) {
        console_log($result);
        return;
    }

    if ($result) {
        require __DIR__ . '/../../views/category.php';
        console_log($result);
    } else {
        echo "Нет товара по такому id";
    }
}

function showCategoriesByParentId($parent_id)
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
        echo "Нет категории по такому id";
    }
}
