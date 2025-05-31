<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$code = $_GET['code'] ?? '';
if (!$code) {
    header("Location: department_list.php");
    exit;
}

$code = $conn->real_escape_string($code);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deptName = $conn->real_escape_string($_POST['DepartmentName']);

    // Update query
    $updateSql = "UPDATE department_master SET DepartmentName='$deptName' WHERE DepartmentCode='$code'";
    if ($conn->query($updateSql)) {
        header("Location: department_list.php?msg=updated");
        exit;
    } else {
        $error = "Update failed: " . $conn->error;
    }
}

// Fetch current data
$sql = "SELECT * FROM department_master WHERE DepartmentCode='$code'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "Department not found.";
    exit;
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f9f9f9; }
        .container { margin-top: 40px; margin-bottom: 40px; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Department Master</span>
        <span class="text-light">
            <a href="department_list.php" class="text-light text-decoration-none">📋 Department List</a>
        </span>
    </div>
</nav>

<div class="container">
    <h2>Edit Department - <?= htmlspecialchars($code) ?></h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="DepartmentCode" class="form-label">Department Code</label>
            <input type="text" class="form-control" id="DepartmentCode" value="<?= htmlspecialchars($code) ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="DepartmentName" class="form-label">Department Name</label>
            <input type="text" name="DepartmentName" class="form-control" id="DepartmentName" required value="<?= htmlspecialchars($row['DepartmentName']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Department</button>
        <a href="department_list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
