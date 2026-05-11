<?php
require_once __DIR__ . '/config/auth.php';

global $branches;

$branchId = isset($_GET['branch']) ? (int) $_GET['branch'] : 0;
$error = '';

if (!isset($branches[$branchId])) {
    http_response_code(404);
    die('Invalid branch selected.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    if (login_branch($branchId, $username, $password)) {
        header('Location: attendance.php');
        exit();
    }

    $error = 'Invalid username or password.';
}

$pageTitle = 'Login - ' . $branches[$branchId]['name'];
require __DIR__ . '/includes/header.php';
?>

<main class="auth-page">
    <form method="POST" class="login-box">
        <h1><?php echo e($branches[$branchId]['name']); ?> Login</h1>
        <?php if ($error !== ''): ?>
            <div class="alert error"><?php echo e($error); ?></div>
        <?php endif; ?>
        <input type="text" name="username" placeholder="User ID" class="input-field" required>
        <input type="password" name="password" placeholder="Password" class="input-field" required>
        <button type="submit" class="btn">Login</button>
    </form>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
