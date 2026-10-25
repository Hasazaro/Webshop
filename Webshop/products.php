<?php
require_once __DIR__ . '/includes/config.php';

$products = $pdo->query('SELECT * FROM products ORDER BY name')->fetchAll();

$pageTitle = 'Alle producten';
require __DIR__ . '/includes/header.php';
?>

<div class="page-hero">
    <h1>Alle <span>Producten</span></h1>
    <p>Ons volledige assortiment verse producten</p>
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <i class="bx bx-chevron-right"></i>
        <span>Producten</span>
    </div>
</div>

<section class="products page-section">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Alle <span>Producten</span></h1>
                <p><?= count($products) ?> producten gevonden</p>
            </div>
        </div>
        <?php include __DIR__ . '/includes/product-grid.php'; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
