<?php
require_once __DIR__ . '/config/auth.php';

global $branches;

$pageTitle = 'Select Branch';
require __DIR__ . '/includes/header.php';
?>

<main>
    <section class="hero compact">
        <h1>Select Branch</h1>
        <p>Choose a branch to log in and manage attendance.</p>
    </section>

    <section class="branches">
        <?php foreach ($branches as $id => $branch): ?>
            <a class="branch-card" href="login.php?branch=<?php echo (int) $id; ?>">
                <h2><?php echo e($branch['name']); ?></h2>
            </a>
        <?php endforeach; ?>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
