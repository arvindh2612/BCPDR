<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM asset_class WHERE id = $id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $conn->real_escape_string($_POST["asset_class_code"]);
    $name = $conn->real_escape_string($_POST["asset_class_name"]);
    $conn->query("UPDATE asset_class SET asset_class_code = '$code', asset_class_name = '$name' WHERE id = $id");
    header("Location: asset_class_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Asset Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Edit Asset Class</span>
        <a href="asset_class_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Edit Asset Class</h2>
    <form method="post">
        <div class="mb-3">
            <label>Asset Class Code</label>
            <input type="text" name="asset_class_code" class="form-control" value="<?= htmlspecialchars($row['asset_class_code']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Asset Class Name</label>
            <input type="text" name="asset_class_name" class="form-control" value="<?= htmlspecialchars($row['asset_class_name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
