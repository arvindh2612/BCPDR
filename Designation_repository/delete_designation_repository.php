<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$empCode = $_GET['emp'];
$conn->query("DELETE FROM DESIGNATION_REPOSITORY WHERE EmployeeCode = '$empCode'");
header("Location: list_designation_repository.php");
exit;
