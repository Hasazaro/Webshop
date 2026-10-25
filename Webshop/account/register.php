<?php
require_once __DIR__ . '/../includes/config.php';

if (current_user()) {
    redirect('index.php');
}

$errors   = [];
$fullName = '';
$email    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName       = trim($_POST['full_name'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $password       = $_POST['password'] ?? '';
    $passwordRepeat = $_POST['password_repeat'] ?? '';

    // 1. Check the input on the server. The browser checks can be skipped, these can't.
    if ($fullName === '') {
        $errors[] = 'Vul je naam in.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Vul een geldig e-mailadres in.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Je wachtwoord moet minimaal 8 tekens lang zijn.';
    }
    if ($password !== $passwordRepeat) {
        $errors[] = 'De wachtwoorden komen niet overeen.';
    }

    // 2. Is the email address already in use?
    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Er bestaat al een account met dit e-mailadres.';
        }
    }

    // 3. Save the user. password_hash() turns the password into a secure, salted hash.
    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$fullName, $email, password_hash($password, PASSWORD_DEFAULT)]);

        // Log the new user in straight away.
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => (int) $pdo->lastInsertId(), 'name' => $fullName, 'role' => 'customer'];
        redirect('index.php');
    }
}

$pageTitle = 'Registreren';
require __DIR__ . '/../includes/header.php';
?>

<div class="Registration">
    <div class="con">
        <div class="title">Account aanmaken</div>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endforeach; ?>

        <form method="post">
            <div class="user-details">
                <label class="input-box">
                    <span class="details">Naam</span>
                    <input type="text" name="full_name" value="<?= e($fullName) ?>" autocomplete="name" required>
                </label>
                <label class="input-box">
                    <span class="details">E-mailadres</span>
                    <input type="email" name="email" value="<?= e($email) ?>" autocomplete="email" required>
                </label>
                <label class="input-box">
                    <span class="details">Wachtwoord (min. 8 tekens)</span>
                    <input type="password" name="password" autocomplete="new-password" minlength="8" required>
                </label>
                <label class="input-box">
                    <span class="details">Herhaal wachtwoord</span>
                    <input type="password" name="password_repeat" autocomplete="new-password" required>
                </label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-block">Registreren</button>
            </div>
        </form>

        <p class="form-switch">Heb je al een account? <a href="login.php">Log hier in</a></p>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
