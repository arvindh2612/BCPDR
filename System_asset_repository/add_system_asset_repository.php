<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");

// Fetch system codes from system_master
$systems = $conn->query("SELECT system_code FROM system_master ORDER BY system_code");

// Fetch asset codes from asset_master
$assets = $conn->query("SELECT asset_id_code FROM asset_master ORDER BY asset_id_code");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $system_code = $conn->real_escape_string($_POST["system_code"]);
    $asset_code = $conn->real_escape_string($_POST["asset_code"]);
    $effective_date = $conn->real_escape_string($_POST["effective_date"]);

    $conn->query("INSERT INTO system_asset_repository (system_code, asset_code, effective_date)
                  VALUES ('$system_code', '$asset_code', '$effective_date')");

    header("Location: system_asset_repository_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add System Asset Repository</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Add System Asset Repository</span>
        <a href="system_asset_repository_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Add Entry</h2>
    <form method="post">
        <div class="mb-3">
            <label>System Code</label>
            <select name="system_code" class="form-select" required>
                <option value="" disabled selected>Select System Code</option>
                <?php
                while ($system = $systems->fetch_assoc()) {
                    echo "<option value=\"{$system['system_code']}\">{$system['system_code']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Asset Code</label>
            <select name="asset_code" class="form-select" required>
                <option value="" disabled selected>Select Asset Code</option>
                <?php
                while ($asset = $assets->fetch_assoc()) {
                    echo "<option value=\"{$asset['asset_id_code']}\">{$asset['asset_id_code']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Effective Date</label>
            <input type="date" name="effective_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
