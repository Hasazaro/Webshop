<?php
// Shows one order: order.php?id=5
require_once __DIR__ . '/includes/config.php';
require_login();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$stmt = $pdo->prepare(
    'SELECT orders.*, users.full_name
     FROM orders
     JOIN users ON users.id = orders.user_id
     WHERE orders.id = ?'
);
$stmt->execute([$id]);
$order = $stmt->fetch();

// Only the customer who placed the order (or an admin) may see it.
// Without this check, anyone could change the id in the URL and see other people's orders.
if (!$order || ((int) $order['user_id'] !== current_user()['id'] && !is_admin())) {
    set_flash('error', 'Deze bestelling bestaat niet.');
    redirect('account/orders.php');
}

$stmt = $pdo->prepare('SELECT * FROM order_items WHERE order_id = ?');
$stmt->execute([$order['id']]);
$items = $stmt->fetchAll();

$isNewOrder = isset($_GET['new']);

$pageTitle = 'Bestelling #' . $order['id'];
require __DIR__ . '/includes/header.php';
?>

<section class="admin-page">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Bestelling <span>#<?= (int) $order['id'] ?></span></h1>
                <p>
                    Geplaatst op <?= date('d-m-Y \o\m H:i', strtotime($order['created_at'])) ?>
                    <?php if (is_admin()): ?> door <?= e($order['full_name']) ?><?php endif; ?>
                </p>
            </div>
            <a href="<?= APPURL ?>/account/orders.php" class="btn">Al mijn bestellingen</a>
        </div>

        <!-- main.js empties the cart when it sees data-clear-cart (only right after ordering) -->
        <div class="table-wrapper" id="order-details" <?= $isNewOrder ? 'data-clear-cart' : '' ?>>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Prijs</th>
                        <th>Aantal</th>
                        <th>Subtotaal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= e($item['product_name']) ?></td>
                            <td><?= format_price($item['price']) ?></td>
                            <td><?= (int) $item['quantity'] ?></td>
                            <td><?= format_price($item['price'] * $item['quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Totaal</th>
                        <th><?= format_price($order['total']) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
