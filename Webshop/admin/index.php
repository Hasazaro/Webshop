<?php
// Admin: overview of all products (the "R" of CRUD: Read).
require_once __DIR__ . '/../includes/config.php';
require_admin();

$products = $pdo->query('SELECT * FROM products ORDER BY category, name')->fetchAll();

$pageTitle = 'Beheer producten';
require __DIR__ . '/../includes/header.php';
?>

<section class="admin-page">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Beheer <span>producten</span></h1>
                <p><?= count($products) ?> producten in de winkel</p>
            </div>
            <div class="admin-actions">
                <a href="orders.php" class="btn"><i class="bx bx-receipt"></i> Bestellingen</a>
                <a href="product-form.php" class="btn"><i class="bx bx-plus"></i> Nieuw product</a>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Afbeelding</th>
                        <th>Naam</th>
                        <th>Categorie</th>
                        <th>Prijs</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><img src="<?= APPURL ?>/images/<?= e($product['image']) ?>" alt="" class="admin-thumb"></td>
                            <td><?= e($product['name']) ?></td>
                            <td><?= e(CATEGORIES[$product['category']]['name'] ?? 'Onbekend') ?></td>
                            <td><?= format_price($product['price']) ?></td>
                            <td class="admin-actions">
                                <a href="product-form.php?id=<?= (int) $product['id'] ?>" class="btn btn-sm">
                                    <i class="bx bx-edit"></i> Wijzigen
                                </a>
                                <!-- Deleting changes data, so it is a POST form (with CSRF token), never a plain link -->
                                <form method="post" action="product-delete.php"
                                      onsubmit="return confirm('Weet je zeker dat je <?= e(addslashes($product['name'])) ?> wilt verwijderen?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash"></i> Verwijderen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$products): ?>
                        <tr><td colspan="5" class="empty-message">Nog geen producten. Voeg je eerste product toe.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
