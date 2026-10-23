<?php

/** @var array $result */
?>
<!DOCTYPE html>
<html lang="ru">
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<body>
    <h5>Категория: <?= htmlspecialchars($result['category']['name']) ?></h5>
    <h1><?= htmlspecialchars($result['name']) ?></h1>
    <h2>Производитель: <?= htmlspecialchars($result['manufacturer']) ?></h2>
    <h2>id категории: <?= htmlspecialchars($result['category_id']) ?></h2>
    <?
    if (empty($result['images'])) {
    ?>
        <img src="<?= $GLOBALS['defaultImageSrc'] ?>" style="max-width: 25%; height: auto;">
    <?
    }
    ?>
    <? foreach ($result['images'] as $image) {
    ?>
        <img src="<?= $image['img_url'] ?>" style="max-width: 25%; height: auto;">
    <?
    } ?>
    <table>
        <tr>
            <th>Цвет</th>
            <th>Цена (руб.)</th>
            <th>Размер</th>
            <th>Наличие (шт.)</th>
        </tr>
        <? foreach ($result['variants'] as $variant) {
        ?>
            <tr>
                <td><?= htmlspecialchars($variant['color']) ?></td>
                <td><?= htmlspecialchars($variant['price']) ?></td>
                <td><?= htmlspecialchars($variant['size']) ?></td>
                <td><?= htmlspecialchars($variant['stock']) ?></td>
            </tr>
        <?
        } ?>
    </table>
</body>

</html>