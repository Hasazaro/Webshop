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

$sql = "SELECT * FROM products WHERE category = 2";
$dbStatement = $dbConnection->prepare($sql);
$dbStatement->execute();
$products = $dbStatement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="page-hero">
    <h1>Verse <span>Groenten</span></h1>
    <p>Dagelijks verse groenten rechtstreeks van de boer</p>
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <i class='bx bx-chevron-right'></i>
        <a href="Categories.php">Categorieën</a>
        <i class='bx bx-chevron-right'></i>
        <span>Groenten</span>
    </div>
</div>

<section class="products" style="padding-top:3rem;">
    <div class="section-wrapper">
        <div class="heading">
            <div>
                <h1>Verse <span>Groenten</span></h1>
                <p>Dagelijks vers binnen</p>
            </div>
        </div>
        <div class="products-container">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                <div class="box">
                    <i class='bx bx-like'></i>
                    <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                    <span class="category-tag">Verse groenten</span>
                    <h2><?= htmlspecialchars($product['name']); ?></h2>
                    <h3 class="price">€<?= htmlspecialchars($product['price']); ?> <span>/ kg</span></h3>
                    <i class='bx bx-cart-alt'></i>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:var(--text-muted);text-align:center;padding:3rem;grid-column:1/-1;">Geen producten gevonden in deze categorie.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <a href="index.php" class="logo"><i class="bx bxs-basket"></i> JUMBO</a>
            <p>Jouw lokale supermarkt voor verse producten, dagelijkse boodschappen en meer.</p>
            <div class="footer-socials">
                <a href="#"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-instagram'></i></a>
                <a href="#"><i class='bx bxl-twitter'></i></a>
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
            <h3>Contact</h3>
            <div class="contact-item"><i class='bx bx-map'></i><span>Marktstraat 1, Amsterdam</span></div>
            <div class="contact-item"><i class='bx bx-phone'></i><span>+31 20 123 4567</span></div>
            <div class="contact-item"><i class='bx bx-envelope'></i><span>info@jumbo.nl</span></div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2025 JUMBO Supermarkt. Alle rechten voorbehouden.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="main.js"></script>
</body>
</html>
