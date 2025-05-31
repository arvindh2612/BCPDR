<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$code = $_GET['code'] ?? '';
$code = $conn->real_escape_string($code);

if ($code) {
    $conn->query("DELETE FROM CompanyMaster WHERE CompanyCode = '$code'");
}

header("Location: list_company.php");
exit;
?>
