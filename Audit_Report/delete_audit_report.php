<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['audit_no'])) {
    $audit_no = (int)$_GET['audit_no'];
    $conn->query("DELETE FROM audit_report WHERE audit_no = $audit_no");
}

header("Location: audit_report_list.php");
exit();
?>
