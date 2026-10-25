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
                <span class="tag">Vers & Lekker</span>
                <h1>Ons prijswinnende<br><span>appeltaartje</span></h1>
                <p>Om van te genieten bij elke gelegenheid</p>
                <a href="#products" class="btn">Shop nu <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <img src="images/home1.avif" alt="Appeltaart">
        </div>
        <div class="swiper-slide container">
            <div class="home-text">
                <span class="tag">Dagverse producten</span>
                <h1>Verse groenten<br><span>elke dag</span></h1>
                <p>Rechtstreeks van de boer naar jouw tafel</p>
                <a href="#categories" class="btn">Bekijk alles <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <img src="images/home2.png" alt="Verse groenten">
        </div>
        <div class="swiper-slide container">
            <div class="home-text">
                <span class="tag">Speciale aanbiedingen</span>
                <h1>Beste kwaliteit<br><span>laagste prijs</span></h1>
                <p>Elke dag de beste deals voor jou</p>
                <a href="#products" class="btn">Bekijk aanbiedingen <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <img src="images/home3.png" alt="Aanbiedingen">
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
