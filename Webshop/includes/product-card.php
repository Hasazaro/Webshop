<?php
// One product tile, included inside the foreach loop of product-grid.php.
// The category label and unit ("/ blik", "/ zak") come from CATEGORIES in config.php.
/** @var array $product  a row from the products table (set by the loop in product-grid.php) */
$productCategory = CATEGORIES[$product['category']] ?? ['name' => '', 'unit' => 'stuk'];
?>
<div class="box">
    <i class="bx bx-like"></i>
    <img src="<?= APPURL ?>/images/<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
    <?php if ($productCategory['name']): ?>
        <span class="category-tag"><?= e($productCategory['name']) ?></span>
    <?php endif; ?>
    <h3><?= e($product['name']) ?></h3>
    <?php if (!empty($product['description'])): ?>
        <p class="description"><?= e($product['description']) ?></p>
    <?php endif; ?>
    <p class="price"><?= format_price($product['price']) ?> <span>/ <?= e($productCategory['unit']) ?></span></p>
    <i class="bx bx-cart-alt add-to-cart"
       data-id="<?= (int) $product['id'] ?>"
       data-name="<?= e($product['name']) ?>"
       data-price="<?= e($product['price']) ?>"></i>
</div>
