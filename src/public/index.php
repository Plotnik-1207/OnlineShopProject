<?php

$filePath = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (is_file($filePath)) {
    return false;
}

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require_once(__DIR__ . '/../src/Controllers/product.php');
require_once(__DIR__ . '/../src/Controllers/category.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$segments = explode('/', trim($uri, '/'));

switch ($segments[0]) {
    case '':
        echo "Главная страница";
        break;
    case 'faq':
        echo "О нас";
        break;
    case 'categories':
        echo "Категории товаров";
        break;
    case 'catalog':
        if (count($segments) > 1) {
            showProductsByCategoryId($segments[1]);
        } else {
            echo "Товары";
        }
        break;
    case 'product':
        if (count($segments) > 1) {
            showProduct($segments[1]);
        } else {
            echo "Категории товаров";
        }
        break;
    default:
        http_response_code(404);
        echo "404";
}

function console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ');';
    echo '</script>';
}
