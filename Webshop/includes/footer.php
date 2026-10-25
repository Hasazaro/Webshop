<!-- Bottom of every page: footer and scripts -->
<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <a href="<?= APPURL ?>/index.php" class="logo"><i class="bx bxs-joystick"></i> <?= APP_NAME ?></a>
            <p>Snacks, energydrinks, noodles en pizza, bezorgd bij gaming cafés en aan je eigen setup. Nooit meer pauzeren voor eten.</p>
            <div class="footer-socials">
                <a href="#" aria-label="Discord"><i class="bx bxl-discord-alt"></i></a>
                <a href="#" aria-label="Twitch"><i class="bx bxl-twitch"></i></a>
                <a href="#" aria-label="Instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" aria-label="TikTok"><i class="bx bxl-tiktok"></i></a>
            </div>
        </div>
        <div class="footer-col">
            <h3>Categorieën</h3>
            <ul>
                <?php foreach (CATEGORIES as $id => $category): ?>
                    <li><a href="<?= APPURL ?>/category.php?id=<?= $id ?>"><?= e($category['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Informatie</h3>
            <ul>
                <li><a href="#">Over ons</a></li>
                <li><a href="#">Bezorging</a></li>
                <li><a href="#">Voor gaming cafés</a></li>
                <li><a href="#">Privacybeleid</a></li>
                <li><a href="#">Algemene voorwaarden</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Contact</h3>
            <div class="contact-item"><i class="bx bx-map"></i><span>Pixelstraat 8, Amsterdam</span></div>
            <div class="contact-item"><i class="bx bx-phone"></i><span>+31 20 123 4567</span></div>
            <div class="contact-item"><i class="bx bx-time"></i><span>Elke dag: 12:00–03:00</span></div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© <?= date('Y') ?> <?= APP_NAME ?>. Schoolproject, geen echte winkel.</p>
        <p>Gemaakt voor gamers, door een gamer <i class="bx bxs-heart footer-heart"></i></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?= asset('main.js') ?>"></script>
</body>
</html>
