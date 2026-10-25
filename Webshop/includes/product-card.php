<?php
// One product tile. Expects $product (a row from the products table).
// Optional: $categoryTag (label above the name) and $unit (e.g. 'kg' or 'stuk').
$unit = $unit ?? 'kg';
?>
<div class="box">
    <i class="bx bx-like"></i>
    <img src="<?= APPURL ?>/images/<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
    <?php if (!empty($categoryTag)): ?>
        <span class="category-tag"><?= e($categoryTag) ?></span>
    <?php endif; ?>
    <h2><?= e($product['name']) ?></h2>
    <?php if (!empty($product['description'])): ?>
        <p class="description"><?= e($product['description']) ?></p>
    <?php endif; ?>
    <h3 class="price"><?= format_price($product['price']) ?> <span>/ <?= e($unit) ?></span></h3>
    <i class="bx bx-cart-alt add-to-cart"
       data-id="<?= (int) $product['id'] ?>"
       data-name="<?= e($product['name']) ?>"
       data-price="<?= e($product['price']) ?>"></i>
</div>
