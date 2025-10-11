<?php
session_start();
$DB_HOST='localhost'; $DB_USER='root'; $DB_PASS=''; $DB_NAME='branch1';
$conn=new mysqli($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);
if($conn->connect_error){die("DB error: ".$conn->connect_error);}

$today=date('Y-m-d');
$students=$conn->query("SELECT id FROM students ORDER BY id ASC");

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_attendance'])){
    $present=$_POST['present']??[];
    $bandhu=intval($_POST['bandhu']??0);
    $bhagini=intval($_POST['bhagini']??0);
    $total=$bandhu+$bhagini;
    $prasad=trim($_POST['prasad']??'');

    foreach($students as $s){
        $sid=$s['id'];
        $status=in_array((string)$sid,$present)?'present':'absent';
        $conn->query("INSERT INTO attendance (student_id,date,status,bandhu,bhagini,total,prasad)
            VALUES ($sid,'$today','$status',$bandhu,$bhagini,$total,'$prasad')
            ON DUPLICATE KEY UPDATE status='$status',bandhu=$bandhu,bhagini=$bhagini,total=$total,prasad='$prasad'");
    }
    header("Location: present.php?success=1");
    exit();
}

if(isset($_GET['view_today'])){
    $todayData=$conn->query("SELECT student_id FROM attendance WHERE date='$today' AND status='present'");
}

if(isset($_GET['view_date'])){
    $selected=$_GET['view_date'];
    $oldData=$conn->query("SELECT student_id FROM attendance WHERE date='$selected' AND status='present'");
}
?>
<!DOCTYPE html>
<html lang="mr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>उपस्थिती</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 10px;
}
.container {
    max-width: 800px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
h2 {
    text-align: center;
    margin-bottom: 10px;
}
.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 8px 0;
    align-items: center;
}
label {
    font-weight: bold;
    min-width: 70px;
}
input[type=number], input[type=text], input[type=date] {
    flex: 1;
    min-width: 100px;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 8px;
}
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
    gap: 10px;
    margin: 20px 0;
}
.btn-student {
    background: #ecf0f1;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}
.btn-student:hover {
    background: #dcdde1;
    transform: scale(1.05);
}
.btn-student.active {
    background: #2ecc71;
    color: #fff;
    transform: scale(1.08);
}
.actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: center;
    margin-top: 10px;
}
button {
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    width: 80%;
    max-width: 300px;
}
.save {
    background: #3498db;
    color: #fff;
}
.view {
    background: #27ae60;
    color: #fff;
}
.present-list {
    background: #d5f5e3;
    margin-top: 10px;
    padding: 10px;
    border-radius: 8px;
}
@media (max-width: 500px) {
    h2 { font-size: 20px; }
    .btn-student { padding: 12px; font-size: 16px; }
    button { width: 100%; }
}
</style>
<script>
function toggle(id){
    let btn=document.getElementById('btn-'+id);
    let chk=document.getElementById('chk-'+id);
    btn.classList.toggle('active');
    chk.checked=btn.classList.contains('active');
}
function calcTotal(){
    let b=parseInt(document.getElementById('bandhu').value)||0;
    let g=parseInt(document.getElementById('bhagini').value)||0;
    document.getElementById('total').value=b+g;
}
</script>
</head>
<body>
<div class="container">
<h2>📋 उपस्थिती</h2>
<form method="POST">
    <div class="form-row">
        <label>दिनांक:</label>
        <input type="date" name="date" value="<?php echo $today; ?>" readonly>
    </div>
    <div class="form-row">
        <label>प्रसाद:</label>
        <input type="text" name="prasad">
    </div>
    <div class="form-row">
        <label>बंधू:</label>
        <input type="number" id="bandhu" name="bandhu" value="0" oninput="calcTotal()">
        <label>भगिनी:</label>
        <input type="number" id="bhagini" name="bhagini" value="0" oninput="calcTotal()">
        <label>एकूण:</label>
        <input type="number" id="total" name="total" readonly value="0">
    </div>

    <div class="grid">
        <?php
        $students->data_seek(0);
        while($s=$students->fetch_assoc()): ?>
            <div class="btn-student" id="btn-<?php echo $s['id']; ?>" onclick="toggle(<?php echo $s['id']; ?>)">
                <?php echo $s['id']; ?>
            </div>
            <input type="checkbox" name="present[]" value="<?php echo $s['id']; ?>" id="chk-<?php echo $s['id']; ?>" style="display:none">
        <?php endwhile; ?>
    </div>
    <div class="actions">
        <button type="submit" name="save_attendance" class="save">💾 Save Attendance</button>
    </div>
</form>

<div class="actions">
    <form method="GET">
        <button type="submit" name="view_today" value="1" class="view">👁 आजचे उपस्थित</button>
    </form>
    <form method="GET">
        <input type="date" name="view_date" required>
        <button type="submit" class="view">📅 जुने रेकॉर्ड</button>
    </form>
</div>

<?php if(isset($todayData)): ?>
<div class="present-list">
    <h3>✅ आजचे उपस्थित</h3>
    <?php while($row=$todayData->fetch_assoc()){echo "ID: ".$row['student_id']." ";} ?>
</div>
<?php endif; ?>

<?php if(isset($oldData)): ?>
<div class="present-list">
    <h3>📜 मागील उपस्थित</h3>
    <?php while($row=$oldData->fetch_assoc()){echo "ID: ".$row['student_id']." ";} ?>
</div>
<?php endif; ?>
</div>
</body>
</html>
