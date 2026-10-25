<?php
// Table with a list of orders. Expects $orders; shows a "Klant" column when $showCustomer is true.
$showCustomer = $showCustomer ?? false;
?>
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Bestelling</th>
                <th>Datum</th>
                <?php if ($showCustomer): ?><th>Klant</th><?php endif; ?>
                <th>Producten</th>
                <th>Totaal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= (int) $order['id'] ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></td>
                    <?php if ($showCustomer): ?><td><?= e($order['full_name']) ?></td><?php endif; ?>
                    <td><?= (int) $order['item_count'] ?></td>
                    <td><?= format_price($order['total']) ?></td>
                    <td><a href="<?= APPURL ?>/order.php?id=<?= (int) $order['id'] ?>" class="btn btn-sm">Bekijken</a></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$orders): ?>
                <tr><td colspan="6" class="empty-message">Nog geen bestellingen.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
