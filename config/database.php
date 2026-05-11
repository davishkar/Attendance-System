<?php
declare(strict_types=1);

require_once __DIR__ . '/app.php';

function db_for_branch(int $branchId): mysqli
{
    global $branches;

    if (!isset($branches[$branchId])) {
        http_response_code(404);
        die('Invalid branch selected.');
    }

    $conn = new mysqli('localhost', 'root', '', $branches[$branchId]['database']);

    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }

    $conn->set_charset('utf8mb4');

    return $conn;
}

