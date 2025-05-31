<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
$id = (int)$_GET['id'];
$row = $conn->query("SELECT * FROM system_master WHERE id = $id")->fetch_assoc();

// Fetch employee names for dropdown
$employees = $conn->query("SELECT first_name FROM employees");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $system_code = $_POST["system_code"];
    $system_name = $_POST["system_name"];
    $system_owner = $_POST["system_owner"];
    $criticality = $_POST["criticality"];
    $mtd = $_POST["mtd"];
    $rpo = $_POST["rpo"];
    $rto = $_POST["rto"];

    $conn->query("UPDATE system_master SET 
        system_code = '$system_code',
        system_name = '$system_name',
        system_owner = '$system_owner',
        criticality = '$criticality',
        mtd = $mtd,
        rpo = $rpo,
        rto = $rto
        WHERE id = $id");

    header("Location: system_master_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Edit System</span>
        <a href="system_master_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <form method="post">
        <div class="mb-3">
            <label>System Code</label>
            <input type="text" name="system_code" class="form-control" value="<?= $row['system_code'] ?>" maxlength="10" required>
        </div>
        <div class="mb-3">
            <label>System Name</label>
            <input type="text" name="system_name" class="form-control" value="<?= $row['system_name'] ?>" maxlength="40" required>
        </div>
        <div class="mb-3">
            <label>System Owner</label>
            <select name="system_owner" class="form-select" required>
                <option value="">Select Owner</option>
                <?php while ($emp = $employees->fetch_assoc()) { 
                    $selected = ($row['system_owner'] == $emp['first_name']) ? 'selected' : '';
                    echo "<option value='{$emp['first_name']}' $selected>{$emp['first_name']}</option>";
                } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Criticality</label>
            <select name="criticality" class="form-select" required>
                <option value="Tier 1 – Mission-Critical" <?= $row['criticality'] == 'Tier 1 – Mission-Critical' ? 'selected' : '' ?>>Tier 1 – Mission-Critical</option>
                <option value="Tier 2 – Critical" <?= $row['criticality'] == 'Tier 2 – Critical' ? 'selected' : '' ?>>Tier 2 – Critical</option>
                <option value="Tier 3 – Important" <?= $row['criticality'] == 'Tier 3 – Important' ? 'selected' : '' ?>>Tier 3 – Important</option>
                <option value="Tier 4 – Noncritical" <?= $row['criticality'] == 'Tier 4 – Noncritical' ? 'selected' : '' ?>>Tier 4 – Noncritical</option>
            </select>
        </div>
        <div class="mb-3">
            <label>MTD (hrs)</label>
            <input type="number" name="mtd" class="form-control" value="<?= $row['mtd'] ?>" min="0" required>
        </div>
        <div class="mb-3">
            <label>RPO (hrs)</label>
            <input type="number" name="rpo" class="form-control" value="<?= $row['rpo'] ?>" min="0" required>
        </div>
        <div class="mb-3">
            <label>RTO (hrs)</label>
            <input type="number" name="rto" class="form-control" value="<?= $row['rto'] ?>" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Update System</button>
    </form>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
