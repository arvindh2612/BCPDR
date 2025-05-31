<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid category ID.");
}

// Optional: Check if category exists before deleting
$check = $conn->query("SELECT * FROM vendor_category WHERE id = $id");
if ($check->num_rows === 0) {
    die("Vendor category not found.");
}

$delete = "DELETE FROM vendor_category WHERE id = $id";

if ($conn->query($delete)) {
    header("Location: vendor_category_list.php");
    exit();
} else {
    echo "Error deleting category: " . $conn->error;
}

$conn->close();
?>
