<?php
// One page for every category: category.php?id=2
// The category's name, text and icon come from CATEGORIES in includes/config.php.
require_once __DIR__ . '/includes/config.php';

$id       = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$category = CATEGORIES[$id] ?? null;

if (!$category) {
    set_flash('error', 'Deze categorie bestaat niet.');
    redirect('categories.php');
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE category = ? ORDER BY name');
$stmt->execute([$id]);
$products = $stmt->fetchAll();

$pageTitle = $category['name'];
require __DIR__ . '/includes/header.php';
?>

<main>
    <section class="page-hero">
        <h1><i class="bx <?= e($category['icon']) ?>" aria-hidden="true"></i> <?= e($category['name']) ?></h1>
        <p><?= e($category['description']) ?></p>
        <nav class="breadcrumb" aria-label="Kruimelpad">
            <a href="index.php">Home</a>
            <i class="bx bx-chevron-right" aria-hidden="true"></i>
            <a href="categories.php">Categorieën</a>
            <i class="bx bx-chevron-right" aria-hidden="true"></i>
            <span aria-current="page"><?= e($category['name']) ?></span>
        </nav>
    </section>

    <section class="products page-section">
        <div class="section-wrapper">
            <div class="heading">
                <div>
                    <h2><?= e($category['name']) ?></h2>
                    <p><?= count($products) ?> producten</p>
                </div>
            </div>
            <?php include __DIR__ . '/includes/product-grid.php'; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
