<?php
// Central settings. Every page includes this file first.

// Name of the shop, shown in the logo, page titles and footer.
define('APP_NAME', 'LevelUp Snacks');

// Address of the project on the web server. Change this if the folder name is different.
define('APPURL', 'http://localhost/webshop');

// Database settings (XAMPP defaults)
define('DB_HOST', 'localhost');
define('DB_NAME', 'web-shop');
define('DB_USER', 'root');
define('DB_PASS', '');

// Product categories. The key (1-5) is the number stored in products.category.
// Everything about a category lives here: the menu, category tiles, category page and product cards all read it.
// Icons come from Boxicons (https://boxicons.com).
define('CATEGORIES', [
    1 => [
        'name'        => 'Chips & Snacks',
        'subtitle'    => 'Knapperig & hartig',
        'description' => 'Chips, nootjes en snacks om tussen de potjes door te knabbelen.',
        'icon'        => 'bxs-cookie',
        'unit'        => 'zak',
    ],
    2 => [
        'name'        => 'Energydrinks',
        'subtitle'    => 'Voor lange sessies',
        'description' => 'Energydrinks voor als het nog maar één potje is (om 3 uur \'s nachts).',
        'icon'        => 'bxs-bolt',
        'unit'        => 'blik',
    ],
    3 => [
        'name'        => 'Frisdrank',
        'subtitle'    => 'Ijskoud',
        'description' => 'Cola, sinas, ice tea en meer: ijskoud bij je bezorgd.',
        'icon'        => 'bxs-drink',
        'unit'        => 'fles',
    ],
    4 => [
        'name'        => 'Noodles',
        'subtitle'    => 'Klaar in 3 minuten',
        'description' => 'Instant noodles en cup noodles: heet water erbij en je kunt weer verder.',
        'icon'        => 'bxs-bowl-hot',
        'unit'        => 'cup',
    ],
    5 => [
        'name'        => 'Pizza',
        'subtitle'    => 'Vers uit de oven',
        'description' => 'Pizza\'s en pizzapunten voor de hele squad.',
        'icon'        => 'bxs-pizza',
        'unit'        => 'stuk',
    ],
]);

// Start the session here, so every page knows who is logged in.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
