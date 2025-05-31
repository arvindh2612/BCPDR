<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $conn->query("DELETE FROM asset_master WHERE id = $id");
}

header("Location: asset_master_list.php");
exit();
?>
