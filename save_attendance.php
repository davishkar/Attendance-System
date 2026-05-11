<?php
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/database.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['save_attendance'])) {
    header('Location: attendance.php');
    exit();
}

$conn = db_for_branch(current_branch_id());
$date = $_POST['date'] ?? date('Y-m-d');

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    $date = date('Y-m-d');
}

$presentIds = array_map('intval', $_POST['present'] ?? []);
$presentLookup = array_flip($presentIds);
$bandhu = max(0, (int) ($_POST['bandhu'] ?? 0));
$bhagini = max(0, (int) ($_POST['bhagini'] ?? 0));
$total = $bandhu + $bhagini;
$prasad = trim($_POST['prasad'] ?? '');

$students = $conn->query('SELECT id FROM students ORDER BY id ASC');
if (!$students) {
    die('Error fetching students: ' . $conn->error);
}

$stmt = $conn->prepare(
    'INSERT INTO attendance (student_id, date, status, bandhu, bhagini, total, prasad)
     VALUES (?, ?, ?, ?, ?, ?, ?)
     ON DUPLICATE KEY UPDATE
        status = VALUES(status),
        bandhu = VALUES(bandhu),
        bhagini = VALUES(bhagini),
        total = VALUES(total),
        prasad = VALUES(prasad)'
);

if (!$stmt) {
    die('Error preparing attendance save: ' . $conn->error);
}

$conn->begin_transaction();

try {
    while ($student = $students->fetch_assoc()) {
        $studentId = (int) $student['id'];
        $status = isset($presentLookup[$studentId]) ? 'present' : 'absent';

        $stmt->bind_param('issiiis', $studentId, $date, $status, $bandhu, $bhagini, $total, $prasad);

        if (!$stmt->execute()) {
            throw new RuntimeException($stmt->error);
        }
    }

    $conn->commit();
} catch (Throwable $e) {
    $conn->rollback();
    die('Error saving attendance: ' . $e->getMessage());
}

header('Location: attendance.php?saved=1&date=' . urlencode($date));
exit();
