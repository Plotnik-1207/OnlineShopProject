<?php

/** @var string $categoryName */
/** @var array $result */
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($categoryName) ?></title>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px;
        }

        .grid-item {
            background-color: #f0f0f0;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .item-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <h1><?= htmlspecialchars($categoryName) ?></h1>

    <div class="grid-container">
        <?php foreach ($result as $item): ?>
            <?php
            $imgSrc = !empty($item['img_url']) ? $item['img_url'] : $GLOBALS['defaultImageSrc'];
            ?>
            <div class="grid-item">
                <img
                    src="<?= htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8') ?>"
                    onerror="this.onerror=null; this.src='<?= htmlspecialchars($GLOBALS['defaultImageSrc'], ENT_QUOTES, 'UTF-8') ?>';"
                    alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>"
                    class="item-img">
                <div><strong><?= htmlspecialchars($item['min_price'] ?? '0') ?> ₽</strong></div>
                <div><?= htmlspecialchars($item['name']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>