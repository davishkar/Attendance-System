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
    'SELECT a.student_id, a.status, a.bandhu, a.bhagini, a.total, a.prasad
     FROM attendance a
     WHERE a.date = ?
     ORDER BY a.student_id ASC'
);
if (!$stmt) {
    die('Error preparing report: ' . $conn->error);
}
$stmt->bind_param('s', $date);
$stmt->execute();
$attendance = $stmt->get_result();

$summary = [
    'present' => 0,
    'absent' => 0,
    'bandhu' => 0,
    'bhagini' => 0,
    'total' => 0,
];
$rows = [];

while ($row = $attendance->fetch_assoc()) {
    $rows[] = $row;
    $status = $row['status'] === 'present' ? 'present' : 'absent';
    $summary[$status]++;
    $summary['bandhu'] = (int) $row['bandhu'];
    $summary['bhagini'] = (int) $row['bhagini'];
    $summary['total'] = (int) $row['total'];
}

$pageTitle = 'Reports - ' . current_branch_name();
require __DIR__ . '/includes/header.php';
?>

<main class="container">
    <div class="page-heading">
        <div>
            <h1>Attendance Report</h1>
            <p><?php echo e(current_branch_name()); ?></p>
        </div>
        <a class="btn secondary" href="export_attendance.php?date=<?php echo e($date); ?>">Export CSV</a>
    </div>

    <form method="GET" class="toolbar">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" value="<?php echo e($date); ?>" required>
        <button type="submit" class="btn">View</button>
    </form>

    <section class="stats">
        <div><strong><?php echo $summary['present']; ?></strong><span>Present</span></div>
        <div><strong><?php echo $summary['absent']; ?></strong><span>Absent</span></div>
        <div><strong><?php echo $summary['bandhu']; ?></strong><span>Bandhu</span></div>
        <div><strong><?php echo $summary['bhagini']; ?></strong><span>Bhagini</span></div>
        <div><strong><?php echo $summary['total']; ?></strong><span>Total</span></div>
    </section>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Status</th>
                    <th>Bandhu</th>
                    <th>Bhagini</th>
                    <th>Total</th>
                    <th>Prasad</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($rows) === 0): ?>
                    <tr><td colspan="6">No attendance records found for this date.</td></tr>
                <?php endif; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo (int) $row['student_id']; ?></td>
                        <td><span class="status <?php echo e($row['status']); ?>"><?php echo e(ucfirst($row['status'])); ?></span></td>
                        <td><?php echo (int) $row['bandhu']; ?></td>
                        <td><?php echo (int) $row['bhagini']; ?></td>
                        <td><?php echo (int) $row['total']; ?></td>
                        <td><?php echo e($row['prasad']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
