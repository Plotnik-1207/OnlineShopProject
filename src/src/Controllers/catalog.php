<?php
require_once(__DIR__ . '/../../config/database.php');

function catalogHandle($id)
{
    if (is_null($id) or isCategoryHasChildren($id)) {
        showCategoriesByParentId($id);
    } else if (!getCategoryById($id)) {
        header('Location: /catalog/', true, 301);
        exit;
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

function getProductsByCategoryId($id, $limit, $offset)
{
    $pdo = connectDatabase();

    $sql = $pdo->prepare('SELECT p.id, p.name, pi.img_url, MIN(pv.price) AS min_price
                        FROM products p
                        LEFT JOIN product_variants pv ON pv.product_id = p.id
                        LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
                        WHERE p.category_id = ?
                        GROUP BY p.id, p.name, pi.img_url
                        LIMIT ? OFFSET ?;');

    $sql->bindValue(1, (int)$id, PDO::PARAM_INT);
    $sql->bindValue(2, (int)$limit, PDO::PARAM_INT);
    $sql->bindValue(3, (int)$offset, PDO::PARAM_INT);

    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

function getCategoryByParentId($parent_id)
{
    $pdo = connectDatabase();

    $condition = null;
    $params = null;
    $name = null;
    if (is_null($parent_id)) {
        $condition = 'IS NULL';
        $params = [];
        $name = 'Каталог';
    } else {
        $condition = '= ?';
        $params = [$parent_id];
        $name = getCategoryById($parent_id)['name'];
    }

    $sql = $pdo->prepare("SELECT * FROM categories WHERE parent_id {$condition}");
    $sql->execute($params);

    return [
        'items' => $sql->fetchAll(PDO::FETCH_ASSOC),
        'name'  => $name
    ];
}

function showProductsByCategoryId($id)
{
    $limitParam = $_GET['limit'] ?? null;
    $pageParam = $_GET['page'] ?? null;

    $page = 1;
    $limit = 10;

    if ($pageParam !== null && filter_var($pageParam, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) !== false) {
        $page = (int)$pageParam;
    }

    if ($limitParam !== null && filter_var($limitParam, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) !== false) {
        $limit = (int)$limitParam;
    }

    $offset = $limit * ($page - 1);
    console_log($page);

    $result = getProductsByCategoryId($id, $limit, (int)$offset);
    $categoryName = getCategoryById($id)['name'];

    if (!empty($result)) {
        require __DIR__ . '/../../views/category.php';
    } else {
        $result = [];
        require __DIR__ . '/../../views/category.php';
    }
}

function showCategoriesByParentId($parent_id)
{
    $result = getCategoryByParentId($parent_id);
    if (!$result) {
        console_log($result);
        return;
    }

    if ($result) {
        console_log($result);
        require __DIR__ . '/../../views/categories.php';
    } else {
        echo "Нет категории по такому id";
    }
}
