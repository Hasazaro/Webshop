<?php
// Admin: delete a product (the "D" of CRUD). Only accepts POST requests with a valid CSRF token.
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/image-upload.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin/index.php');
}
csrf_check();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$stmt = $pdo->prepare('SELECT name, image FROM products WHERE id = ?');
$stmt->execute([$id]);
$product = $stmt->fetch();

if ($product) {
    $pdo->prepare('DELETE FROM products WHERE id = ?')->execute([$id]);
    delete_product_image($product['image']);
    set_flash('success', 'Product "' . $product['name'] . '" is verwijderd.');
} else {
    set_flash('error', 'Dit product bestaat niet (meer).');
}

redirect('admin/index.php');
