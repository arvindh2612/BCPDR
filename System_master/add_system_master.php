<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");

// Fetch employee first names
$owners_result = $conn->query("SELECT DISTINCT first_name FROM employees");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $system_code = $_POST["system_code"];
    $system_name = $_POST["system_name"];
    $system_owner = $_POST["system_owner"];
    $criticality = $_POST["criticality"];
    $mtd = $_POST["mtd"];
    $rpo = $_POST["rpo"];
    $rto = $_POST["rto"];

    $stmt = $conn->prepare("INSERT INTO system_master (system_code, system_name, system_owner, criticality, mtd, rpo, rto)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiii", $system_code, $system_name, $system_owner, $criticality, $mtd, $rpo, $rto);
    $stmt->execute();
    $stmt->close();

    header("Location: system_master_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Add System</span>
        <a href="system_master_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <form method="post">
        <div class="mb-3">
            <label>System Code</label>
            <input type="text" name="system_code" class="form-control" maxlength="10" required>
        </div>
        <div class="mb-3">
            <label>System Name</label>
            <input type="text" name="system_name" class="form-control" maxlength="40" required>
        </div>
        <div class="mb-3">
            <label>System Owner</label>
            <select name="system_owner" class="form-select" required>
                <option value="">Select</option>
                <?php while ($row = $owners_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['first_name']) ?>"><?= htmlspecialchars($row['first_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Criticality</label>
            <select name="criticality" class="form-select" required>
                <option value="">Select</option>
                <option value="Tier 1 – Mission-Critical">Tier 1 – Mission-Critical</option>
                <option value="Tier 2 – Critical">Tier 2 – Critical</option>
                <option value="Tier 3 – Important">Tier 3 – Important</option>
                <option value="Tier 4 – Noncritical">Tier 4 – Noncritical</option>
            </select>
        </div>
        <div class="mb-3">
            <label>MTD (hrs)</label>
            <input type="number" name="mtd" class="form-control" min="0" required>
        </div>
        <div class="mb-3">
            <label>RPO (hrs)</label>
            <input type="number" name="rpo" class="form-control" min="0" required>
        </div>
        <div class="mb-3">
            <label>RTO (hrs)</label>
            <input type="number" name="rto" class="form-control" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Add System</button>
    </form>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
