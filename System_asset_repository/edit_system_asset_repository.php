<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");

$id = (int)$_GET['id'];

// Fetch current record
$result = $conn->query("SELECT * FROM system_asset_repository WHERE id = $id");
$row = $result->fetch_assoc();

// Fetch system codes for dropdown
$systems = $conn->query("SELECT system_code FROM system_master ORDER BY system_code");

// Fetch asset codes for dropdown
$assets = $conn->query("SELECT asset_id_code FROM asset_master ORDER BY asset_id_code");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $system_code = $conn->real_escape_string($_POST["system_code"]);
    $asset_code = $conn->real_escape_string($_POST["asset_code"]);
    $effective_date = $conn->real_escape_string($_POST["effective_date"]);

    $conn->query("UPDATE system_asset_repository SET 
        system_code = '$system_code',
        asset_code = '$asset_code',
        effective_date = '$effective_date'
        WHERE id = $id");

    header("Location: system_asset_repository_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit System Asset Repository</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Edit System Asset Repository</span>
        <a href="system_asset_repository_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Edit Entry</h2>
    <form method="post">
        <div class="mb-3">
            <label>System Code</label>
            <select name="system_code" class="form-select" required>
                <option value="" disabled>Select System Code</option>
                <?php
                // Reset pointer just in case
                $systems->data_seek(0);
                while ($system = $systems->fetch_assoc()) {
                    $selected = ($system['system_code'] === $row['system_code']) ? "selected" : "";
                    echo "<option value=\"" . htmlspecialchars($system['system_code']) . "\" $selected>" . htmlspecialchars($system['system_code']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Asset Code</label>
            <select name="asset_code" class="form-select" required>
                <option value="" disabled>Select Asset Code</option>
                <?php
                $assets->data_seek(0);
                while ($asset = $assets->fetch_assoc()) {
                    $selected = ($asset['asset_id_code'] === $row['asset_code']) ? "selected" : "";
                    echo "<option value=\"" . htmlspecialchars($asset['asset_id_code']) . "\" $selected>" . htmlspecialchars($asset['asset_id_code']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Effective Date</label>
            <input type="date" name="effective_date" class="form-control" value="<?= htmlspecialchars($row['effective_date']) ?>" required>
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
