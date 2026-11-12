<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function redirect(string $url): never {
    header("Location: {$url}");
    exit;
}
function is_logged_in(): bool {
    return isset($_SESSION['user']);
}
function is_admin(): bool {
    return is_logged_in() && ($_SESSION['user']['role'] ?? '') === 'admin';
}
function require_login(): void {
    if (!is_logged_in()) {
        set_flash('Please log in first.', 'error');
        redirect('login.php');
    }
}
function require_admin(): void {
    if (!is_admin()) {
        http_response_code(403);
        exit('Access denied. Admin account required.');
    }
}
function set_flash(string $message, string $type = 'success'): void {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}
function get_flash(): ?array {
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function verify_csrf(): void {
    $sent = $_POST['csrf_token'] ?? '';
    if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
        http_response_code(419);
        exit('Invalid request token. Go back and try again.');
    }
}
function money(float|string $amount): string {
    return 'Rs. ' . number_format((float)$amount, 2);
}
