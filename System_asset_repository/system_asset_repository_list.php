<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
$result = $conn->query("SELECT * FROM system_asset_repository");
?>

<!DOCTYPE html>
<html>
<head>
    <title>System Asset Repository List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">System Asset Repository</span>
        <a href="add_system_asset_repository.php" class="btn btn-success">Add New</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Repository List</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>System Code</th>
                <th>Asset Code</th>
                <th>Effective Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['system_code']) ?></td>
                    <td><?= htmlspecialchars($row['asset_code']) ?></td>
                    <td><?= htmlspecialchars($row['effective_date']) ?></td>
                    <td>
                        <a href="edit_system_asset_repository.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"> Edit</a>
                        <a href="delete_system_asset_repository.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</body>
</html>
