<?php
require_once __DIR__ . '/includes/config.php';

$stmt = $pdo->prepare('SELECT * FROM products WHERE category = ? ORDER BY name');
$stmt->execute([3]);
$products = $stmt->fetchAll();

$pageTitle   = 'Dranken';
$categoryTag = 'Dranken';
$unit        = 'stuk';
require __DIR__ . '/includes/header.php';
?>

<div class="page-hero">
    <h1>Verse <span>Dranken</span></h1>
    <p>Frisdrank, sap, water en meer</p>
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <i class="bx bx-chevron-right"></i>
        <a href="categories.php">Categorieën</a>
        <i class="bx bx-chevron-right"></i>
        <span>Dranken</span>
    </div>
</div>

<section class="products page-section">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Onze <span>Dranken</span></h1>
                <p>Voor elke dorst het juiste drankje</p>
            </div>
        </div>
        <?php include __DIR__ . '/includes/product-grid.php'; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
