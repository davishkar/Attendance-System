<?php
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/database.php';

require_login();

$conn = db_for_branch(current_branch_id());
$today = $_GET['date'] ?? date('Y-m-d');

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $today)) {
    $today = date('Y-m-d');
}

$students = $conn->query('SELECT id FROM students ORDER BY id ASC');
if (!$students) {
    die('Error fetching students: ' . $conn->error);
}

$present = [];
$meta = [
    'bandhu' => 0,
    'bhagini' => 0,
    'total' => 0,
    'prasad' => '',
];

$stmt = $conn->prepare('SELECT student_id, status, bandhu, bhagini, total, prasad FROM attendance WHERE date = ?');
if (!$stmt) {
    die('Error preparing attendance lookup: ' . $conn->error);
}
$stmt->bind_param('s', $today);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    if ($row['status'] === 'present') {
        $present[(int) $row['student_id']] = true;
    }

    $meta = [
        'bandhu' => (int) $row['bandhu'],
        'bhagini' => (int) $row['bhagini'],
        'total' => (int) $row['total'],
        'prasad' => (string) $row['prasad'],
    ];
}

$pageTitle = 'Attendance - ' . current_branch_name();
require __DIR__ . '/includes/header.php';
?>

<main class="container">
    <div class="page-heading">
        <div>
            <h1>Attendance</h1>
            <p><?php echo e(current_branch_name()); ?></p>
        </div>
        <a class="btn secondary" href="reports.php?date=<?php echo e($today); ?>">View Report</a>
    </div>

    <?php if (isset($_GET['saved'])): ?>
        <div class="alert success">Attendance saved successfully.</div>
    <?php endif; ?>

    <form method="POST" action="save_attendance.php" class="panel">
        <div class="form-row">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" value="<?php echo e($today); ?>" required>
        </div>

        <div class="form-row">
            <label for="prasad">Prasad</label>
            <input type="text" id="prasad" name="prasad" value="<?php echo e($meta['prasad']); ?>">
        </div>

        <div class="form-row split">
            <label for="bandhu">Bandhu</label>
            <input type="number" id="bandhu" name="bandhu" min="0" value="<?php echo (int) $meta['bandhu']; ?>" oninput="calcTotal()">

            <label for="bhagini">Bhagini</label>
            <input type="number" id="bhagini" name="bhagini" min="0" value="<?php echo (int) $meta['bhagini']; ?>" oninput="calcTotal()">

            <label for="total">Total</label>
            <input type="number" id="total" name="total" value="<?php echo (int) $meta['total']; ?>" readonly>
        </div>

        <div class="student-grid">
            <?php while ($student = $students->fetch_assoc()): ?>
                <?php
                $studentId = (int) $student['id'];
                $isPresent = isset($present[$studentId]);
                ?>
                <button
                    class="student-toggle<?php echo $isPresent ? ' active' : ''; ?>"
                    id="btn-<?php echo $studentId; ?>"
                    type="button"
                    onclick="toggleStudent(<?php echo $studentId; ?>)"
                >
                    <?php echo $studentId; ?>
                </button>
                <input
                    type="checkbox"
                    name="present[]"
                    value="<?php echo $studentId; ?>"
                    id="chk-<?php echo $studentId; ?>"
                    <?php echo $isPresent ? 'checked' : ''; ?>
                    hidden
                >
            <?php endwhile; ?>
        </div>

        <div class="actions">
            <button type="submit" name="save_attendance" class="btn">Save Attendance</button>
        </div>
    </form>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
