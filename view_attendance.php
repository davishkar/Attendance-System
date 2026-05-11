<?php
$date = isset($_GET['date']) ? '?date=' . urlencode($_GET['date']) : '';
header('Location: reports.php' . $date);
exit();
