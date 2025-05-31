<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
$result = $conn->query("SELECT * FROM system_master ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>System Master List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">System Master</span>
        <a href="add_system_master.php" class="text-light text-decoration-none">➕ Add System</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>System List</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>System Code</th>
                <th>System Name</th>
                <th>System Owner</th>
                <th>Criticality</th>
                <th>MTD (hrs)</th>
                <th>RPO (hrs)</th>
                <th>RTO (hrs)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['system_code']) ?></td>
                <td><?= htmlspecialchars($row['system_name']) ?></td>
                <td><?= htmlspecialchars($row['system_owner']) ?></td>
                <td><?= htmlspecialchars($row['criticality']) ?></td>
                <td><?= htmlspecialchars($row['mtd']) ?></td>
                <td><?= htmlspecialchars($row['rpo']) ?></td>
                <td><?= htmlspecialchars($row['rto']) ?></td>
                <td>
                    <a href="edit_system_master.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="delete_system_master.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this system?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</body>
</html>
