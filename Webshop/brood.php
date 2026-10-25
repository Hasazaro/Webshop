<?php
require_once __DIR__ . '/includes/config.php';

$stmt = $pdo->prepare('SELECT * FROM products WHERE category = ? ORDER BY name');
$stmt->execute([4]);
$products = $stmt->fetchAll();

$pageTitle   = 'Brood';
$categoryTag = 'Brood & Banket';
$unit        = 'stuk';
require __DIR__ . '/includes/header.php';
?>

<div class="page-hero">
    <h1>Vers <span>Brood</span></h1>
    <p>Elke dag vers gebakken brood en banket</p>
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <i class="bx bx-chevron-right"></i>
        <a href="categories.php">Categorieën</a>
        <i class="bx bx-chevron-right"></i>
        <span>Brood</span>
    </div>
</div>

<section class="products page-section">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Vers <span>Brood</span></h1>
                <p>Dagelijks vers gebakken</p>
            </div>
        </div>
        <?php include __DIR__ . '/includes/product-grid.php'; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
