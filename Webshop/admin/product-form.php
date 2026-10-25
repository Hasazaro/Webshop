<?php
// Admin: add a new product (Create) or change an existing one (Update).
// product-form.php       -> new product
// product-form.php?id=5  -> edit product 5
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/image-upload.php';
require_admin();

$id      = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$isEdit  = (bool) $id;
$errors  = [];
$product = ['name' => '', 'description' => '', 'price' => '', 'category' => '', 'image' => ''];

// When editing: load the existing product, so the form is filled in.
if ($isEdit) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        set_flash('error', 'Dit product bestaat niet (meer).');
        redirect('admin/index.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    // 1. Read the form. Accept both "1,99" and "1.99" as price.
    $product['name']        = trim($_POST['name'] ?? '');
    $product['description'] = trim($_POST['description'] ?? '');
    $product['price']       = str_replace(',', '.', trim($_POST['price'] ?? ''));
    $product['category']    = (int) ($_POST['category'] ?? 0);

    // 2. Validate every field on the server.
    if ($product['name'] === '' || mb_strlen($product['name']) > 100) {
        $errors[] = 'Vul een naam in (maximaal 100 tekens).';
    }
    if (mb_strlen($product['description']) > 255) {
        $errors[] = 'De omschrijving mag maximaal 255 tekens zijn.';
    }
    if (!is_numeric($product['price']) || $product['price'] <= 0 || $product['price'] > 9999) {
        $errors[] = 'Vul een geldige prijs in, bijvoorbeeld 1,99.';
    }
    if (!isset(CATEGORIES[$product['category']])) {
        $errors[] = 'Kies een categorie.';
    }

    $hasNewImage = ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
    if (!$isEdit && !$hasNewImage) {
        $errors[] = 'Kies een afbeelding.';
    }

    // 3. Only save the image when everything else is valid (otherwise we'd keep unused files).
    $oldImage = $product['image'];
    if (!$errors && $hasNewImage) {
        try {
            $product['image'] = upload_product_image($_FILES['image']);
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
        }
    }

    // 4. Save in the database with a prepared statement.
    if (!$errors) {
        $values = [$product['name'], $product['description'], $product['price'], $product['category'], $product['image']];

        if ($isEdit) {
            $stmt = $pdo->prepare('UPDATE products SET name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?');
            $stmt->execute([...$values, $id]);

            // Only now that the new image is saved in the database, the old file can go.
            if ($hasNewImage) {
                delete_product_image($oldImage);
            }
            set_flash('success', 'Product "' . $product['name'] . '" is bijgewerkt.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute($values);
            set_flash('success', 'Product "' . $product['name'] . '" is toegevoegd.');
        }

        // Redirect after a POST, so refreshing the page doesn't submit the form twice.
        redirect('admin/index.php');
    }
}

$pageTitle = $isEdit ? 'Product wijzigen' : 'Nieuw product';
require __DIR__ . '/../includes/header.php';
?>

<div class="Registration">
    <div class="con">
        <div class="title"><?= $isEdit ? 'Product wijzigen' : 'Nieuw product' ?></div>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endforeach; ?>

        <!-- enctype="multipart/form-data" is required, otherwise the browser doesn't send the file -->
        <form method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="user-details">
                <label class="input-box">
                    <span class="details">Naam</span>
                    <input type="text" name="name" value="<?= e($product['name']) ?>" maxlength="100" required>
                </label>
                <label class="input-box">
                    <span class="details">Prijs (€)</span>
                    <input type="text" name="price" value="<?= e(str_replace('.', ',', $product['price'])) ?>"
                           inputmode="decimal" placeholder="1,99" required>
                </label>
                <label class="input-box">
                    <span class="details">Categorie</span>
                    <select name="category" required>
                        <option value="">Kies een categorie</option>
                        <?php foreach (CATEGORIES as $number => $name): ?>
                            <option value="<?= $number ?>" <?= (int) $product['category'] === $number ? 'selected' : '' ?>>
                                <?= e($name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="input-box">
                    <span class="details">Afbeelding (JPG, PNG of WEBP, max. 2 MB)</span>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp" <?= $isEdit ? '' : 'required' ?>>
                </label>
                <label class="input-box input-box-full">
                    <span class="details">Omschrijving</span>
                    <textarea name="description" rows="3" maxlength="255"><?= e($product['description']) ?></textarea>
                </label>
                <?php if ($isEdit && $product['image']): ?>
                    <div class="input-box input-box-full current-image">
                        <span class="details">Huidige afbeelding (kies een nieuwe om te vervangen)</span>
                        <img src="<?= APPURL ?>/images/<?= e($product['image']) ?>" alt="" class="admin-thumb">
                    </div>
                <?php endif; ?>
            </div>
            <div class="button">
                <input type="submit" value="<?= $isEdit ? 'Wijzigingen opslaan' : 'Product toevoegen' ?>">
            </div>
        </form>

        <p class="form-switch"><a href="index.php">← Terug naar overzicht</a></p>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
