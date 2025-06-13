<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");

// Enable error reporting
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Check if 'id' is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Prepare delete statement
    $stmt = $conn->prepare("DELETE FROM system_master WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the list page
header("Location: system_master_list.php");
exit();
?>