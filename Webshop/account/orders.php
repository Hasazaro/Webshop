<?php
// "Mijn bestellingen": the orders of the logged-in customer.
require_once __DIR__ . '/../includes/config.php';
require_login();

$stmt = $pdo->prepare(
    'SELECT orders.*,
            (SELECT SUM(quantity) FROM order_items WHERE order_id = orders.id) AS item_count
     FROM orders
     WHERE orders.user_id = ?
     ORDER BY orders.created_at DESC'
);
$stmt->execute([current_user()['id']]);
$orders = $stmt->fetchAll();

$pageTitle = 'Mijn bestellingen';
require __DIR__ . '/../includes/header.php';
?>

<section class="admin-page">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Mijn <span>bestellingen</span></h1>
                <p><?= count($orders) ?> bestellingen</p>
            </div>
        </div>
        <?php include __DIR__ . '/../includes/orders-table.php'; ?>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
