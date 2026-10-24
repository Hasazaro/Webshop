<?php
define('APPURL', 'http://localhost/webshop');
include "navbar.php";

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "web-shop";

try {
    $dsn = "mysql:host=$hostName;dbname=$dbName;charset=utf8";
    $dbConnection = new PDO($dsn, $dbUser, $dbPassword);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$sql = "SELECT * FROM products LIMIT 8";
$dbStatement = $dbConnection->prepare($sql);
$dbStatement->execute();
$products = $dbStatement->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Slider -->
<section class="home swiper" id="home">
    <div class="swiper-wrapper">
        <div class="swiper-slide container">
            <div class="home-text">
                <span class="tag">Vers & Lekker</span>
                <h1>Ons prijswinnende<br><span>appeltaartje</span></h1>
                <p>Om van te genieten bij elke gelegenheid</p>
                <a href="#products" class="btn">Shop nu <i class='bx bx-right-arrow-alt'></i></a>
            </div>
            <img src="images/home1.avif" alt="Appeltaart">
        </div>
        <div class="swiper-slide container">
            <div class="home-text">
                <span class="tag">Dagverse producten</span>
                <h1>Verse groenten<br><span>elke dag</span></h1>
                <p>Rechtstreeks van de boer naar jouw tafel</p>
                <a href="#categories" class="btn">Bekijk alles <i class='bx bx-right-arrow-alt'></i></a>
            </div>
            <img src="images/home2.png" alt="Verse groenten">
        </div>
        <div class="swiper-slide container">
            <div class="home-text">
                <span class="tag">Speciale aanbiedingen</span>
                <h1>Beste kwaliteit<br><span>laagste prijs</span></h1>
                <p>Elke dag de beste deals voor jou</p>
                <a href="#products" class="btn">Bekijk aanbiedingen <i class='bx bx-right-arrow-alt'></i></a>
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
            <a href="Categories.php" class="btn">Alles bekijken <i class='bx bx-right-arrow-alt'></i></a>
        </div>
        <div class="categories-container">
            <a href="fruiten.php" class="box box1">
                <img src="images/box1.png" alt="Fruit">
                <h2>Fruit</h2>
                <span>Vers fruit</span>
                <i class='bx bx-right-arrow-alt'></i>
            </a>
            <a href="groenten.php" class="box box2">
                <img src="images/box2.png" alt="Groenten">
                <h2>Groenten</h2>
                <span>Verse groenten</span>
                <i class='bx bx-right-arrow-alt'></i>
            </a>
            <a href="drinken.php" class="box box3">
                <img src="images/box3.png" alt="Dranken">
                <h2>Dranken</h2>
                <span>Frisdrank & meer</span>
                <i class='bx bx-right-arrow-alt'></i>
            </a>
            <a href="brood.php" class="box box4">
                <img src="images/box4.png" alt="Brood">
                <h2>Brood</h2>
                <span>Vers gebakken</span>
                <i class='bx bx-right-arrow-alt'></i>
            </a>
            <a href="spices.php" class="box box5">
                <img src="images/box5.png" alt="Kruiden">
                <h2>Kruiden</h2>
                <span>Specerijen</span>
                <i class='bx bx-right-arrow-alt'></i>
            </a>
        </div>
    </div>
</section>

<!-- Products -->
<section class="products" id="products">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Populaire <span>producten</span></h1>
                <p>Onze best verkochte items</p>
            </div>
            <a href="products.php" class="btn">Meer bekijken <i class='bx bx-right-arrow-alt'></i></a>
        </div>
        <div class="products-container">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                <div class="box">
                    <i class='bx bx-like'></i>
                    <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                    <span class="category-tag"><?= htmlspecialchars($product['name']); ?></span>
                    <h2><?= htmlspecialchars($product['description'] ?? $product['name']); ?></h2>
                    <h3 class="price">€<?= htmlspecialchars($product['price']); ?> <span>/ kg</span></h3>
                    <i class='bx bx-cart-alt'></i>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:var(--text-muted);text-align:center;padding:2rem;">Geen producten gevonden.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <a href="index.php" class="logo"><i class="bx bxs-basket"></i> JUMBO</a>
            <p>Jouw lokale supermarkt voor verse producten, dagelijkse boodschappen en meer. Kwaliteit en versheid staan bij ons centraal.</p>
            <div class="footer-socials">
                <a href="#" aria-label="Facebook"><i class='bx bxl-facebook'></i></a>
                <a href="#" aria-label="Instagram"><i class='bx bxl-instagram'></i></a>
                <a href="#" aria-label="Twitter"><i class='bx bxl-twitter'></i></a>
                <a href="#" aria-label="WhatsApp"><i class='bx bxl-whatsapp'></i></a>
            </div>
        </div>
        <div class="footer-col">
            <h3>Categorieën</h3>
            <ul>
                <li><a href="fruiten.php">Fruit</a></li>
                <li><a href="groenten.php">Groenten</a></li>
                <li><a href="drinken.php">Dranken</a></li>
                <li><a href="brood.php">Brood</a></li>
                <li><a href="spices.php">Kruiden</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Informatie</h3>
            <ul>
                <li><a href="#">Over ons</a></li>
                <li><a href="#">Bezorging</a></li>
                <li><a href="#">Retourneren</a></li>
                <li><a href="#">Privacybeleid</a></li>
                <li><a href="#">Algemene voorwaarden</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Contact</h3>
            <div class="contact-item"><i class='bx bx-map'></i><span>Marktstraat 1, Amsterdam</span></div>
            <div class="contact-item"><i class='bx bx-phone'></i><span>+31 20 123 4567</span></div>
            <div class="contact-item"><i class='bx bx-envelope'></i><span>info@jumbo.nl</span></div>
            <div class="contact-item"><i class='bx bx-time'></i><span>Ma–Za: 08:00–21:00</span></div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2025 JUMBO Supermarkt. Alle rechten voorbehouden.</p>
        <p>Gemaakt met <i class='bx bx-heart' style="color:var(--primary)"></i> voor onze klanten</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="main.js"></script>
</body>
</html>
