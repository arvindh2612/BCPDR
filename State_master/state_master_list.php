<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
$result = $conn->query("SELECT * FROM state_master ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>State Master List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">State Master</span>
        <a href="add_state_master.php" class="btn btn-success">Add State</a>
    </div>
</nav>

<div class="container mt-4">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>State Code</th>
                <th>State Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['state_code']) ?></td>
                <td><?= htmlspecialchars($row['state_name']) ?></td>
                <td>
                    <a href="edit_state_master.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="delete_state_master.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
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
