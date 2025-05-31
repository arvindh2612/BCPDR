<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_code = $_POST['department_code'];
    $department_name = $_POST['department_name'];

    // Simple validation could be added here

    $sql = "INSERT INTO department_master (DepartmentCode, DepartmentName) VALUES ('$department_code', '$department_name')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Department added successfully'); window.location='add_department.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-top: 40px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Department Master</span>
        <span class="text-light">
            <a href="add_department.php" class="text-light text-decoration-none me-3">➕ Add Department</a>
            <a href="department_list.php" class="text-light text-decoration-none">📋 Department List</a>
        </span>
    </div>
</nav>

<div class="container">
    <div class="form-container">
        <h2 class="mb-4">Add Department</h2>
        <form method="post">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="department_code">Department Code *</label>
                    <input type="text" name="department_code" id="department_code" class="form-control" maxlength="10" required>
                </div>
                <div class="col-md-6">
                    <label for="department_name">Department Name *</label>
                    <input type="text" name="department_name" id="department_name" class="form-control" maxlength="100" required>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Add Department</button>
                <a href="department_list.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
