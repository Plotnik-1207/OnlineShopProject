<?php

/** @var array $result */
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
    <div><?= htmlspecialchars($result['name']) ?></div>
    <div class="grid-container">
        <? foreach ($result['items'] as $category) {
        ?>
            <div class=".grid-item">
                <img src="<?= $category['img_url'] ?>" onerror="this.onerror=null; this.src='<?= $GLOBALS['defaultImageSrc'] ?>';" style="max-width: 200px; height: 400px;">
                <div><?= htmlspecialchars($category['name']) ?></div>
            </div>
        <?
        } ?>
    </div>
</body>

</html>