<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_code = $conn->real_escape_string($_POST['category_code']);
    $category_name = $conn->real_escape_string($_POST['category_name']);

    $sql = "INSERT INTO vendor_category (category_code, category_name) VALUES ('$category_code', '$category_name')";

    if ($conn->query($sql) === TRUE) {
        $message = "Vendor category added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Vendor Category</title>
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
        <span class="navbar-brand mb-0 h1">Vendor Category Master</span>
        <span class="text-light">
            <a href="add_vendor_category.php" class="text-light text-decoration-none me-3">➕ Add Category</a>
            <a href="vendor_category_list.php" class="text-light text-decoration-none">📋 Category List</a>
        </span>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Add Vendor Category</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="category_code" class="form-label">Category Code</label>
            <input type="text" name="category_code" id="category_code" class="form-control" maxlength="10" required>
        </div>
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control" maxlength="100" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>

</body>
</html>
