<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete only if valid numeric ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Prepare and execute the deletion
    $stmt = $conn->prepare("DELETE FROM state_master WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the list page
header("Location: state_master_list.php"); // Make sure this is your correct list filename
exit;
?>
