<?php
// Category tiles (used on the home page and the categories page), built from CATEGORIES in config.php.
?>
<div class="categories-container">
    <?php foreach (CATEGORIES as $id => $category): ?>
        <a href="<?= APPURL ?>/category.php?id=<?= $id ?>" class="box cat-<?= $id ?>">
            <span class="category-icon" aria-hidden="true"><i class="bx <?= e($category['icon']) ?>"></i></span>
            <h3><?= e($category['name']) ?></h3>
            <span><?= e($category['subtitle']) ?></span>
            <i class="bx bx-right-arrow-alt" aria-hidden="true"></i>
        </a>
    <?php endforeach; ?>
</div>
