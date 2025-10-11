<?php
session_start();
$DB_HOST='localhost'; $DB_USER='root'; $DB_PASS=''; $DB_NAME='branch1';
$conn=new mysqli($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);
if($conn->connect_error){ die("DB Error: ".$conn->connect_error); }

$today=date('Y-m-d');
$students=$conn->query("SELECT * FROM students ORDER BY id ASC");

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_attendance'])){
    $present=$_POST['present']??[];
    $bandhu=intval($_POST['bandhu']??0);
    $bhagini=intval($_POST['bhagini']??0);
    $total=$bandhu+$bhagini;
    $prasad=$conn->real_escape_string(trim($_POST['prasad']??''));

    $students->data_seek(0);
    while($s=$students->fetch_assoc()){
        $sid=$s['id'];
        $status=in_array((string)$sid,$present)?'present':'absent';
        $sql="INSERT INTO attendance (student_id,date,status,bandhu,bhagini,total,prasad)
              VALUES($sid,'$today','$status',$bandhu,$bhagini,$total,'$prasad')
              ON DUPLICATE KEY UPDATE 
              status='$status', bandhu=$bandhu, bhagini=$bhagini, total=$total, prasad='$prasad'";
        $conn->query($sql);
    }
    header("Location: save_attendance.php?success=1");
    exit();
}
?>
