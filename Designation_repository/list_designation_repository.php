<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM DESIGNATION_REPOSITORY ORDER BY EmployeeCode ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Designation Repository List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Add Designation</span>
        <span class="text-light">
            <a href="add_designation_repository.php" class="text-light text-decoration-none me-3">🏢 Add </a>
            <a href="list_designation_repository.php" class="text-light text-decoration-none">📋 List</a>
        </span>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-4">Designation List</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Employee Code</th>
                <th>Department Code</th>
                <th>Location Code</th>
                <th>Designation Name</th>
                <th>Current</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['EmployeeCode']) ?></td>
                <td><?= htmlspecialchars($row['DepartmentCode']) ?></td>
                <td><?= htmlspecialchars($row['LocationCode']) ?></td>
                <td><?= htmlspecialchars($row['DesignationName']) ?></td>
                <td><?= htmlspecialchars($row['CurrentInPosition']) ?></td>
                <td><?= htmlspecialchars($row['StartDate']) ?></td>
                <td><?= $row['EndDate'] ? htmlspecialchars($row['EndDate']) : '--' ?></td>
                <td>
                    <a href="edit_designation_repository.php?emp=<?= urlencode($row['EmployeeCode']) ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="delete_designation_repository.php?emp=<?= urlencode($row['EmployeeCode']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this entry?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>

</body>
</html>
