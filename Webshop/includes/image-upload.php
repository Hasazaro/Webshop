<?php
// Saving and deleting product images (used by the admin panel).

const UPLOAD_DIR      = __DIR__ . '/../images/products/';
const UPLOAD_MAX_SIZE = 2 * 1024 * 1024; // 2 MB
const ALLOWED_IMAGE_TYPES = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
];

// Saves an uploaded image and returns the path to store in the database, e.g. 'products/a1b2c3.jpg'.
// Throws a RuntimeException with a message for the user when something is wrong.
function upload_product_image(array $file): string
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Het uploaden is mislukt. Probeer het opnieuw.');
    }
    if ($file['size'] > UPLOAD_MAX_SIZE) {
        throw new RuntimeException('De afbeelding mag maximaal 2 MB zijn.');
    }

    // Check the real file content, not the file name: "virus.php" renamed to "photo.jpg" is still PHP.
    $mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!isset(ALLOWED_IMAGE_TYPES[$mimeType])) {
        throw new RuntimeException('Alleen JPG, PNG en WEBP afbeeldingen zijn toegestaan.');
    }

    // Make our own random file name, so a user can never choose the name (or overwrite another file).
    $fileName = bin2hex(random_bytes(8)) . '.' . ALLOWED_IMAGE_TYPES[$mimeType];

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }
    if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $fileName)) {
        throw new RuntimeException('De afbeelding kon niet worden opgeslagen.');
    }

    return 'products/' . $fileName;
}

// Deletes an image that was uploaded through the admin panel.
// Images outside images/products/ (the original demo images) are never deleted.
function delete_product_image(string $image): void
{
    if (!str_starts_with($image, 'products/')) {
        return;
    }
    $path = UPLOAD_DIR . basename($image);
    if (is_file($path)) {
        unlink($path);
    }
}
