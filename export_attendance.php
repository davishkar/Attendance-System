<?php
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/database.php';

require_login();

$conn = db_for_branch(current_branch_id());
$date = $_GET['date'] ?? date('Y-m-d');

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    $date = date('Y-m-d');
}

$stmt = $conn->prepare(
    'SELECT student_id, status, bandhu, bhagini, total, prasad
     FROM attendance
     WHERE date = ?
     ORDER BY student_id ASC'
);
if (!$stmt) {
    die('Error preparing export: ' . $conn->error);
}
$stmt->bind_param('s', $date);
$stmt->execute();
$result = $stmt->get_result();

$filename = 'attendance-' . current_branch_id() . '-' . $date . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Branch', 'Date', 'Student ID', 'Status', 'Bandhu', 'Bhagini', 'Total', 'Prasad']);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        current_branch_name(),
        $date,
        $row['student_id'],
        $row['status'],
        $row['bandhu'],
        $row['bhagini'],
        $row['total'],
        $row['prasad'],
    ]);
}

fclose($output);
exit();
