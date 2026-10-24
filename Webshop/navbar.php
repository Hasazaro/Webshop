<?php
if (!defined('APPURL')) {
    define('APPURL', 'http://localhost/webshop');
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUMBO - Verse producten</title>
    <link rel="stylesheet" href="<?php echo APPURL; ?>/style.css?v=3">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body>
    <header>
        <a href="<?php echo APPURL; ?>/index.php" class="logo">
            <i class="bx bxs-basket"></i> JUMBO
        </a>
        <i class="bx bx-menu" id="menu-icon"></i>
        <ul class="navbar" id="navbar">
            <li><a href="<?php echo APPURL; ?>/index.php" <?php echo ($currentPage=='index.php') ? 'class="home-active"' : ''; ?>>Home</a></li>
            <li><a href="<?php echo APPURL; ?>/Categories.php" <?php echo ($currentPage=='Categories.php') ? 'class="home-active"' : ''; ?>>Categorieën</a></li>
            <li><a href="<?php echo APPURL; ?>/products.php" <?php echo ($currentPage=='products.php') ? 'class="home-active"' : ''; ?>>Producten</a></li>
            <li><a href="<?php echo APPURL; ?>/Login-and-logout/register.php">Registreren</a></li>
        </ul>
        <div class="header-right">
            <div class="profile">
                <img src="<?php echo APPURL; ?>/images/img1.png" alt="Profiel">
                <span>JUMBO</span>
            </div>
            <button class="cart-btn" id="cart-toggle">
                <i class='bx bx-cart'></i>
                <span id="cart-count">0</span>
            </button>
        </div>
    </header>

    <!-- Cart Dropdown -->
    <div class="cart-container" id="cart-container">
        <h2><i class='bx bx-cart'></i> Winkelwagen</h2>
        <ul id="cart-items">
            <li class="cart-empty">Je winkelwagen is leeg</li>
        </ul>
        <button id="checkout">Afrekenen <i class='bx bx-right-arrow-alt'></i></button>
    </div>
