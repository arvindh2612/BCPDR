<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

// Handle Asset Class Insert
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["asset_class_code"], $_POST["asset_class_name"])) {
    $asset_class_code = $conn->real_escape_string($_POST["asset_class_code"]);
    $asset_class_name = $conn->real_escape_string($_POST["asset_class_name"]);

    // Prevent duplicate entries
    $check = $conn->query("SELECT * FROM asset_class WHERE asset_class_code = '$asset_class_code'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO asset_class (asset_class_code, asset_class_name) VALUES ('$asset_class_code', '$asset_class_name')");
        $success_message = "Asset Class added successfully!";
    } else {
        $error_message = "Asset Class Code already exists.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Asset Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Asset Class Master</span>
        <a href="asset_class_list.php" class="text-light text-decoration-none">📄 View All Asset Classes</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Add Asset Class</h2>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Asset Class Code</label>
            <input type="text" name="asset_class_code" class="form-control" required maxlength="10">
        </div>
        <div class="mb-3">
            <label>Asset Class Name</label>
            <input type="text" name="asset_class_name" class="form-control" required maxlength="100">
        </div>
        <button type="submit" class="btn btn-primary">Add Asset Class</button>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
