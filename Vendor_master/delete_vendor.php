<?php
// delete_vendor.php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['vendor_code'])) {
    $vendor_code = $conn->real_escape_string($_GET['vendor_code']);

    // Optional: Check if the vendor exists first (for better UX)
    $check = $conn->query("SELECT id FROM vendors WHERE vendor_code = '$vendor_code'");
    if ($check->num_rows > 0) {
        $conn->query("DELETE FROM vendors WHERE vendor_code = '$vendor_code'");
    }
}

// Redirect back to vendor list
header("Location: vendor_list.php");
exit;
?>
