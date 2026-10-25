<?php
// Grid of product tiles. Expects $products; uses $categoryTag and $unit if they are set.
?>
<div class="products-container">
    <?php if ($products): ?>
        <?php foreach ($products as $product): ?>
            <?php include __DIR__ . '/product-card.php'; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="empty-message">Geen producten gevonden.</p>
    <?php endif; ?>
</div>
