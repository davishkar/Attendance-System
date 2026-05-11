<?php
require_once __DIR__ . '/config/auth.php';

$pageTitle = 'Home - ' . APP_NAME;
require __DIR__ . '/includes/header.php';
?>

<main>
    <section class="hero">
        <h1>Harimandir Attendance</h1>
        <p>Manage branch attendance, review daily records, and export reports from one clean workflow.</p>
    </section>

    <section class="branches">
        <a class="branch-card" href="upasthiti.php">
            <h2>Branch Login</h2>
            <p>Select a branch and mark daily attendance.</p>
        </a>
        <?php if (is_logged_in()): ?>
            <a class="branch-card" href="attendance.php">
                <h2>Attendance</h2>
                <p>Mark or update attendance for <?php echo e(current_branch_name()); ?>.</p>
            </a>
            <a class="branch-card" href="reports.php">
                <h2>Reports</h2>
                <p>View daily attendance summaries and export CSV files.</p>
            </a>
        <?php endif; ?>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
