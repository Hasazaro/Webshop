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
?>

<!-- Page Hero -->
<div class="page-hero">
    <h1>Onze <span>Categorieën</span></h1>
    <p>Kies een categorie om te beginnen met winkelen</p>
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <i class='bx bx-chevron-right'></i>
        <span>Categorieën</span>
    </div>
</div>

<!-- Categories -->
<section class="categories" style="padding-top:3rem;">
    <div class="section-wrapper">
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

<!-- Footer -->
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
