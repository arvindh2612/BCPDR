<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM vendor_category ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Category List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .container {
            margin-top: 40px;
            margin-bottom: 40px;
        }
        .table thead {
            background-color: #212529;
            color: #fff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Vendor Category Master</span>
        <span class="text-light">
            <a href="add_vendor_category.php" class="text-light text-decoration-none me-3">➕ Add Category</a>
            <a href="vendor_category_list.php" class="text-light text-decoration-none">📋 Category List</a>
        </span>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Vendor Category List</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category Code</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['category_code']) ?></td>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td>
                        <a href="edit_vendor_category.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="delete_vendor_category.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3" class="text-center">No vendor categories found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>

</body>
</html>
