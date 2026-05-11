<?php
require_once __DIR__ . '/../config/auth.php';

$pageTitle = $pageTitle ?? APP_NAME;
?>
<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="logo"><?php echo e(APP_NAME); ?></div>
    <button class="menu-toggle" type="button" onclick="toggleMenu()" aria-label="Toggle menu">Menu</button>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="upasthiti.php">Branches</a></li>
            <?php if (is_logged_in()): ?>
                <li><a href="attendance.php">Attendance</a></li>
                <li><a href="reports.php">Reports</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
