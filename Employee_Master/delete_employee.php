<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $conn->query("DELETE FROM employees WHERE id = $id");
}

$conn->close();
header("Location: employee_list.php");
exit;
