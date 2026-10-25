<?php
require_once __DIR__ . '/includes/config.php';

$stmt = $pdo->prepare('SELECT * FROM products WHERE category = ? ORDER BY name');
$stmt->execute([1]);
$products = $stmt->fetchAll();

$pageTitle   = 'Fruit';
$categoryTag = 'Vers fruit';
$unit        = 'kg';
require __DIR__ . '/includes/header.php';
?>

<div class="page-hero">
    <h1>Vers <span>Fruit</span></h1>
    <p>Het lekkerste en versste fruit van het seizoen</p>
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <i class="bx bx-chevron-right"></i>
        <a href="categories.php">Categorieën</a>
        <i class="bx bx-chevron-right"></i>
        <span>Fruit</span>
    </div>
</div>

<section class="products page-section">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Vers <span>Fruit</span></h1>
                <p>Dagelijks vers binnen</p>
            </div>
        </div>
        <?php include __DIR__ . '/includes/product-grid.php'; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
