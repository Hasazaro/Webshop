<?php
// Admin: all orders of all customers.
require_once __DIR__ . '/../includes/config.php';
require_admin();

$orders = $pdo->query(
    'SELECT orders.*, users.full_name,
            (SELECT SUM(quantity) FROM order_items WHERE order_id = orders.id) AS item_count
     FROM orders
     JOIN users ON users.id = orders.user_id
     ORDER BY orders.created_at DESC'
)->fetchAll();

$showCustomer = true;

$pageTitle = 'Alle bestellingen';
require __DIR__ . '/../includes/header.php';
?>

<section class="admin-page">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Alle <span>bestellingen</span></h1>
                <p><?= count($orders) ?> bestellingen</p>
            </div>
            <a href="index.php" class="btn"><i class="bx bx-package"></i> Producten</a>
        </div>
        <?php include __DIR__ . '/../includes/orders-table.php'; ?>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
