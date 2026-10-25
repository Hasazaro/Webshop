<!-- Bottom of every page: footer and scripts -->
<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <a href="<?= APPURL ?>/index.php" class="logo"><i class="bx bxs-basket"></i> JUMBO</a>
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
                <li><a href="<?= APPURL ?>/fruiten.php">Fruit</a></li>
                <li><a href="<?= APPURL ?>/groenten.php">Groenten</a></li>
                <li><a href="<?= APPURL ?>/drinken.php">Dranken</a></li>
                <li><a href="<?= APPURL ?>/brood.php">Brood</a></li>
                <li><a href="<?= APPURL ?>/spices.php">Kruiden</a></li>
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
        <p>© <?= date('Y') ?> JUMBO Supermarkt. Alle rechten voorbehouden.</p>
        <p>Gemaakt met <i class='bx bx-heart' style="color:var(--primary)"></i> voor onze klanten</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?= APPURL ?>/main.js"></script>
</body>
</html>
