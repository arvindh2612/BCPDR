<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is provided and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM system_asset_repository WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the list
header("Location: system_asset_repository_list.php"); // make sure the filename matches your list page
exit;
?>
