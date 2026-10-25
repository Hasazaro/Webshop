<?php
// Top of every page: <head>, navigation and cart dropdown.
// Optional: set $pageTitle before including this file.
$pageTitle   = $pageTitle ?? 'Snacks voor gamers';
$inAdmin     = str_contains($_SERVER['PHP_SELF'], '/admin/');
$currentPage = $inAdmin ? '' : basename($_SERVER['PHP_SELF']);  // admin pages only highlight "Admin"
$user        = current_user();
$flash       = get_flash();

// Returns the "active" class when you are on one of the given pages.
function active_class(array $pages, string $currentPage): string
{
    return in_array($currentPage, $pages, true) ? ' class="home-active"' : '';
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | <?= APP_NAME ?></title>
    <!-- Libraries first, our own stylesheet last, so our styles can override the libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <!-- main.js reads this token when it sends the cart to checkout.php -->
    <meta name="csrf-token" content="<?= csrf_token() ?>">
</head>
<body>
    <header>
        <a href="<?= APPURL ?>/index.php" class="logo">
            <i class="bx bxs-joystick"></i> <?= APP_NAME ?>
        </a>
        <i class="bx bx-menu" id="menu-icon"></i>
        <ul class="navbar" id="navbar">
            <li><a href="<?= APPURL ?>/index.php"<?= active_class(['index.php'], $currentPage) ?>>Home</a></li>
            <li><a href="<?= APPURL ?>/categories.php"<?= active_class(['categories.php', 'category.php'], $currentPage) ?>>Categorieën</a></li>
            <li><a href="<?= APPURL ?>/products.php"<?= active_class(['products.php'], $currentPage) ?>>Producten</a></li>
            <?php if (is_admin()): ?>
                <li><a href="<?= APPURL ?>/admin/index.php"<?= $inAdmin ? ' class="home-active"' : '' ?>>Admin</a></li>
            <?php endif; ?>
            <?php if ($user): ?>
                <li><a href="<?= APPURL ?>/account/orders.php"<?= active_class(['orders.php'], $currentPage) ?>>Bestellingen</a></li>
                <li><a href="<?= APPURL ?>/account/logout.php">Uitloggen</a></li>
            <?php else: ?>
                <li><a href="<?= APPURL ?>/account/login.php"<?= active_class(['login.php'], $currentPage) ?>>Inloggen</a></li>
                <li><a href="<?= APPURL ?>/account/register.php"<?= active_class(['register.php'], $currentPage) ?>>Registreren</a></li>
            <?php endif; ?>
        </ul>
        <div class="header-right">
            <div class="profile">
                <i class="bx bx-user-circle"></i>
                <span><?= $user ? e($user['name']) : 'Gast' ?></span>
            </div>
            <button class="cart-btn" id="cart-toggle" aria-label="Winkelwagen">
                <i class="bx bx-cart"></i>
                <span id="cart-count">0</span>
            </button>
        </div>
    </header>

    <!-- Cart dropdown (filled by main.js) -->
    <div class="cart-container" id="cart-container">
        <h2><i class="bx bx-cart"></i> Winkelwagen</h2>
        <ul id="cart-items">
            <li class="cart-empty">Je winkelwagen is leeg</li>
        </ul>
        <p class="cart-total">Totaal <strong id="cart-total">€ 0,00</strong></p>
        <button id="checkout" class="btn btn-block"
                data-checkout-url="<?= APPURL ?>/checkout.php"
                data-login-url="<?= APPURL ?>/account/login.php?checkout=1"
                data-logged-in="<?= $user ? '1' : '0' ?>">
            Afrekenen <i class="bx bx-right-arrow-alt"></i>
        </button>
    </div>

    <?php if ($flash): ?>
        <!-- Message from the previous page, e.g. "Product opgeslagen" -->
        <div class="flash-message alert alert-<?= e($flash['type']) ?>" id="flash-message">
            <?= e($flash['message']) ?>
        </div>
    <?php endif; ?>
