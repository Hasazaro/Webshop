<?php
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'Categorieën';
require __DIR__ . '/includes/header.php';
?>

<div class="page-hero">
    <h1>Onze <span>Categorieën</span></h1>
    <p>Kies een categorie om te beginnen met winkelen</p>
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <i class="bx bx-chevron-right"></i>
        <span>Categorieën</span>
    </div>
</div>

<section class="categories page-section">
    <div class="section-wrapper">
        <?php include __DIR__ . '/includes/category-grid.php'; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
