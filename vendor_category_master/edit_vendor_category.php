<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'] ?? 0;
$id = (int)$id;

if ($id <= 0) {
    die("Invalid ID.");
}

$query = "SELECT * FROM vendor_category WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows !== 1) {
    die("Vendor category not found.");
}

$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_code = $conn->real_escape_string($_POST['category_code']);
    $category_name = $conn->real_escape_string($_POST['category_name']);

    $updateQuery = "UPDATE vendor_category SET category_code = '$category_code', category_name = '$category_name' WHERE id = $id";

    if ($conn->query($updateQuery)) {
        header("Location: vendor_category_list.php");
        exit();
    } else {
        $error = "Update failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Vendor Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .container {
            margin-top: 40px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Edit Vendor Category</span>
        <span class="text-light">
            <a href="vendor_category_list.php" class="text-light text-decoration-none">📋 Category List</a>
        </span>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Edit Vendor Category</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Category Code</label>
            <input type="text" name="category_code" value="<?= htmlspecialchars($row['category_code']) ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Category Name</label>
            <input type="text" name="category_name" value="<?= htmlspecialchars($row['category_name']) ?>" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="vendor_category_list.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    © 2025 BCPDR System. All rights reserved.
</footer>

</body>
</html>
