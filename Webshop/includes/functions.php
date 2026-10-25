<?php
// Small helper functions used on many pages.

// Escape text before printing it in HTML, so it can't inject HTML or JavaScript (XSS).
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Send the visitor to another page in the project, e.g. redirect('index.php').
function redirect(string $path): void
{
    header('Location: ' . APPURL . '/' . $path);
    exit;
}

// Format a price the Dutch way: 1.5 -> "€ 1,50".
function format_price(float|string $amount): string
{
    return '€ ' . number_format((float) $amount, 2, ',', '.');
}

// The logged-in user as ['id' => ..., 'name' => ..., 'role' => ...], or null when nobody is logged in.
function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_admin(): bool
{
    return (current_user()['role'] ?? '') === 'admin';
}

// Put this at the top of pages that need a logged-in user (e.g. checkout, my orders).
function require_login(): void
{
    if (!current_user()) {
        set_flash('error', 'Log eerst in om verder te gaan.');
        redirect('account/login.php');
    }
}

// Put this at the top of every admin page: everyone who is not an admin is sent away.
function require_admin(): void
{
    if (!current_user()) {
        redirect('account/login.php');
    }
    if (!is_admin()) {
        http_response_code(403);
        exit('Geen toegang: deze pagina is alleen voor beheerders.');
    }
}

// ===== CSRF protection =====
// Every form gets a secret token. Another website can't know it,
// so it can't secretly submit a form (e.g. "delete product") in the admin's name.
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function csrf_check(): void
{
    if (!hash_equals(csrf_token(), $_POST['csrf_token'] ?? '')) {
        http_response_code(419);
        exit('Je sessie is verlopen. Ga terug en probeer het opnieuw.');
    }
}

// ===== Flash messages =====
// A message that is shown once on the next page, e.g. "Product opgeslagen" after a redirect.
function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}
