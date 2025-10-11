<?php
$DB_HOST='localhost'; $DB_USER='root'; $DB_PASS=''; $DB_NAME='branch1';
$conn=new mysqli($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);
if($conn->connect_error){ die("DB Error: ".$conn->connect_error); }

// Get the selected date from GET, default to today
$date = $_GET['date'] ?? date('Y-m-d');

// Fetch attendance for the selected date
$attendance = $conn->query("
    SELECT a.*, s.name 
    FROM attendance a 
    JOIN students s ON a.student_id=s.id 
    WHERE a.date='$date'
");
?>

<!DOCTYPE html>
<html lang="mr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Attendance - <?php echo $date; ?></title>
<style>
body{ font-family:sans-serif; background:#f4f6f9; padding:10px; }
.container{ max-width:900px; margin:auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1);}
h2{ text-align:center; }
form{ display:flex; justify-content:center; gap:10px; flex-wrap:wrap; margin-top:10px;}
input[type=date]{ padding:8px; border-radius:6px; border:1px solid #ccc; }
button{ padding:8px 16px; border:none; border-radius:6px; background:#3498db; color:#fff; cursor:pointer; font-weight:600;}
table{ width:100%; border-collapse: collapse; margin-top:20px;}
th,td{ padding:12px; border:1px solid #ccc; text-align:center;}
th{ background:#3498db; color:#fff;}
.present{ background:#2ecc71; color:#fff; }
.absent{ background:#e74c3c; color:#fff; }
@media(max-width:600px){
    th, td{ font-size:14px; padding:8px; }
    form{ flex-direction:column; }
    button{ width:100%; }
}
</style>
</head>
<body>
<div class="container">
<h2>Attendance for <?php echo $date; ?></h2>

<!-- Select date -->
<form method="GET">
    <label>Select Date:</label>
    <input type="date" name="date" value="<?php echo $date; ?>" required>
    <button type="submit">View</button>
</form>

<!-- Attendance Table -->
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Status</th>
    <th>Bandhu</th>
    <th>Bhagini</th>
    <th>Total</th>
    <th>Prasad</th>
</tr>
<?php if($attendance && $attendance->num_rows>0): ?>
    <?php while($row=$attendance->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td class="<?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></td>
            <td><?php echo $row['bandhu']; ?></td>
            <td><?php echo $row['bhagini']; ?></td>
            <td><?php echo $row['total']; ?></td>
            <td><?php echo $row['prasad']; ?></td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr><td colspan="7">No attendance records found for this date.</td></tr>
<?php endif; ?>
</table>
</div>
</body>
</html>
