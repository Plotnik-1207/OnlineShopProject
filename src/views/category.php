<?php

/** @var array $result */
/** @var string $category */
?>
<!DOCTYPE html>
<html lang="ru">
<style>
    .grid-container {
        display: grid;
        grid-template-columns: 200px 1fr;
        grid-template-rows: auto 1fr auto;
        gap: 15px;
        min-height: 100vh;
    }

    .grid-item {
        background-color: #f0f0f0;
        padding: 20px;
        border: 1px solid #ccc;
    }
</style>

<body>
    <div><?= htmlspecialchars($category) ?></div>
    <div class="grid-container">
        <? foreach ($result as $product) {
        ?>
            <div class=".grid-item">
                <img src="<?= $product['img_url'] ?>" style="max-width: 200px; height: 400px;">
                <div><?= htmlspecialchars($product['min_price']) ?></div>
                <div><?= htmlspecialchars($product['name']) ?></div>
            </div>
        <?
        } ?>
    </div>
</body>

</html>