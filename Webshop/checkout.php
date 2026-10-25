<?php
// Places an order. Receives the cart from main.js as JSON: [{"id": 3, "qty": 2}, ...]
// Prices are NEVER taken from the browser (anyone can change them there), only from the database.
require_once __DIR__ . '/includes/config.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}
csrf_check();

// Show an error on the products page and stop (redirect() ends the script).
function checkout_fail(string $message): void
{
    set_flash('error', $message);
    redirect('products.php');
}

// 1. Read and validate the cart.
$cart = json_decode($_POST['cart'] ?? '', true);
if (!is_array($cart) || !$cart) {
    checkout_fail('Je winkelwagen is leeg.');
}

$quantities = []; // product id => quantity
foreach ($cart as $item) {
    $id  = filter_var($item['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $qty = filter_var($item['qty'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 99]]);
    if ($id === false || $qty === false) {
        checkout_fail('Je winkelwagen bevat een ongeldig product of aantal.');
    }
    $quantities[$id] = ($quantities[$id] ?? 0) + $qty;
}
if (count($quantities) > 50 || max($quantities) > 99) {
    checkout_fail('Je kunt maximaal 99 stuks per product bestellen.');
}

// 2. Get the real names and prices from the database.
// One "?" per product: WHERE id IN (?, ?, ?)
$placeholders = implode(', ', array_fill(0, count($quantities), '?'));
$stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id IN ($placeholders)");
$stmt->execute(array_keys($quantities));
$products = $stmt->fetchAll();

if (count($products) !== count($quantities)) {
    checkout_fail('Een of meer producten zijn niet meer beschikbaar. Verwijder ze uit je winkelwagen.');
}

// 3. Calculate the total in cents (whole numbers), so there are no rounding errors like 0.1 + 0.2 = 0.30000000000000004.
$totalCents = 0;
foreach ($products as $product) {
    $totalCents += (int) round($product['price'] * 100) * $quantities[$product['id']];
}

// 4. Save the order and its items in ONE transaction:
// either everything is saved, or (if something fails halfway) nothing is.
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('INSERT INTO orders (user_id, total) VALUES (?, ?)');
    $stmt->execute([current_user()['id'], $totalCents / 100]);
    $orderId = (int) $pdo->lastInsertId();

    $stmt = $pdo->prepare(
        'INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)'
    );
    foreach ($products as $product) {
        $stmt->execute([$orderId, $product['id'], $product['name'], $product['price'], $quantities[$product['id']]]);
    }

    $pdo->commit();
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log('Checkout failed: ' . $e->getMessage());
    checkout_fail('Er ging iets mis bij het plaatsen van je bestelling. Probeer het opnieuw.');
}

// 5. Show the confirmation (redirect after POST, so a refresh doesn't order twice).
set_flash('success', 'Bedankt! Je bestelling is geplaatst.');
redirect('order.php?id=' . $orderId . '&new=1');
