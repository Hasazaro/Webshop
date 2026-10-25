<?php
require_once __DIR__ . '/../includes/config.php';

// Already logged in? Then there is nothing to do here.
if (current_user()) {
    redirect('index.php');
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Prepared statement: the email is sent separately from the SQL, so it can't change the query.
    $stmt = $pdo->prepare('SELECT id, full_name, password, role FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // A new session id after login protects against session fixation.
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => (int) $user['id'], 'name' => $user['full_name'], 'role' => $user['role']];
        redirect('index.php');
    }

    // One message for both cases, so nobody can find out which email addresses have an account.
    $error = 'E-mailadres of wachtwoord is onjuist.';
}

$pageTitle = 'Inloggen';
require __DIR__ . '/../includes/header.php';
?>

<div class="Registration">
    <div class="con con-small">
        <div class="title">Inloggen</div>

        <?php if (isset($_GET['checkout'])): ?>
            <div class="alert alert-info">Log in om je bestelling af te ronden. Je winkelwagen blijft bewaard.</div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="user-details">
                <label class="input-box input-box-full">
                    <span class="details">E-mailadres</span>
                    <input type="email" name="email" value="<?= e($email) ?>" autocomplete="email" required>
                </label>
                <label class="input-box input-box-full">
                    <span class="details">Wachtwoord</span>
                    <input type="password" name="password" id="password" autocomplete="current-password" required>
                </label>
                <label class="show-password">
                    <input type="checkbox" id="show-password"> Wachtwoord tonen
                </label>
            </div>
            <div class="button">
                <input type="submit" value="Inloggen">
            </div>
        </form>

        <p class="form-switch">Nog geen account? <a href="register.php">Registreer hier</a></p>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
