<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
$result = $conn->query("SELECT * FROM asset_class ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asset Class List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Asset Class Master</span>
        <a href="add_asset_class.php" class="text-light text-decoration-none">➕ Add Asset Class</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Asset Class List</h2>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Asset Class Code</th>
                <th>Asset Class Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['asset_class_code']) ?></td>
                <td><?= htmlspecialchars($row['asset_class_name']) ?></td>
                <td>
                    <a href="edit_asset_class.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="delete_asset_class.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this asset class?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
