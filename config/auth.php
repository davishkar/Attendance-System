<?php
declare(strict_types=1);

require_once __DIR__ . '/app.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function is_logged_in(): bool
{
    return !empty($_SESSION['loggedin']) && !empty($_SESSION['branch']);
}

function current_branch_id(): int
{
    return isset($_SESSION['branch']) ? (int) $_SESSION['branch'] : 0;
}

function current_branch_name(): string
{
    global $branches;

    $branchId = current_branch_id();
    return $branches[$branchId]['name'] ?? 'Branch';
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: upasthiti.php');
        exit();
    }
}

function login_branch(int $branchId, string $username, string $password): bool
{
    global $branches;

    if (!isset($branches[$branchId])) {
        return false;
    }

    $branch = $branches[$branchId];
    $passwordOk = isset($branch['password_hash'])
        ? password_verify($password, $branch['password_hash'])
        : hash_equals($branch['password'], $password);

    if (!hash_equals($branch['username'], $username) || !$passwordOk) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['loggedin'] = true;
    $_SESSION['branch'] = $branchId;

    return true;
}

function logout_user(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}

