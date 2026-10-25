<?php
require_once __DIR__ . '/includes/config.php';

$products = $pdo->query('SELECT * FROM products LIMIT 8')->fetchAll();

$pageTitle = 'Verse producten';
require __DIR__ . '/includes/header.php';
?>

<!-- Hero slider -->
<section class="home swiper" id="home">
    <div class="swiper-wrapper">
        <div class="swiper-slide container">
            <div class="home-text">
                <span class="tag">Bezorgd aan je setup</span>
                <h1>Snacks voor je<br><span>volgende match</span></h1>
                <p>Chips, energydrinks, noodles en pizza, bezorgd bij je gaming café of thuis. Jij blijft in de game.</p>
                <a href="#products" class="btn">Shop nu <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <!-- Decorative icons only, so screen readers skip them (aria-hidden) -->
            <div class="hero-visual" aria-hidden="true">
                <i class="bx bxs-joystick hero-icon"></i>
                <span class="hero-badge badge-1"><i class="bx bxs-pizza"></i></span>
                <span class="hero-badge badge-2"><i class="bx bxs-bolt"></i></span>
                <span class="hero-badge badge-3"><i class="bx bxs-cookie"></i></span>
            </div>
        </div>
        <div class="swiper-slide container">
            <div class="home-text">
                <span class="tag">Late night</span>
                <h1>Energy voor<br><span>de hele nacht</span></h1>
                <p>We bezorgen elke dag tot 03:00. Voor die ene ranked game die toch nog drie werd.</p>
                <a href="category.php?id=2" class="btn">Bekijk energydrinks <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <div class="hero-visual" aria-hidden="true">
                <i class="bx bxs-bolt hero-icon"></i>
                <span class="hero-badge badge-1"><i class="bx bxs-moon"></i></span>
                <span class="hero-badge badge-2"><i class="bx bxs-time-five"></i></span>
                <span class="hero-badge badge-3"><i class="bx bxs-rocket"></i></span>
            </div>
        </div>
        <div class="swiper-slide container">
            <div class="home-text">
                <span class="tag">Squad deals</span>
                <h1>Bestel samen,<br><span>betaal minder</span></h1>
                <p>Pizza en noodles voor je hele team. Ideaal voor LAN-party's en toernooien in je gaming café.</p>
                <a href="products.php" class="btn">Bekijk producten <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <div class="hero-visual" aria-hidden="true">
                <i class="bx bxs-trophy hero-icon"></i>
                <span class="hero-badge badge-1"><i class="bx bxs-bowl-hot"></i></span>
                <span class="hero-badge badge-2"><i class="bx bxs-invader"></i></span>
                <span class="hero-badge badge-3"><i class="bx bxs-pizza"></i></span>
            </div>
        </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</section>

<!-- Categories -->
<section class="categories" id="categories">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Onze <span>categorieën</span></h1>
                <p>Kies uit ons brede assortiment</p>
            </div>
            <a href="categories.php" class="btn">Alles bekijken <i class="bx bx-right-arrow-alt"></i></a>
        </div>
        <?php include __DIR__ . '/includes/category-grid.php'; ?>
    </div>
</section>

<!-- Popular products -->
<section class="products" id="products">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Populaire <span>producten</span></h1>
                <p>Onze best verkochte items</p>
            </div>
            <a href="products.php" class="btn">Meer bekijken <i class="bx bx-right-arrow-alt"></i></a>
        </div>
        <?php include __DIR__ . '/includes/product-grid.php'; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
