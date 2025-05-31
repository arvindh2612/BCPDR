<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = $_GET['id'] ?? null;
if (!$id) die("Invalid request");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize POST data (basic escaping)
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $company = $conn->real_escape_string($_POST['company']);
    $department = $conn->real_escape_string($_POST['department']);
    $designation = $conn->real_escape_string($_POST['designation']);
    $location = $conn->real_escape_string($_POST['location']);
    $phone1 = $conn->real_escape_string($_POST['phone1']);
    $phone2 = $conn->real_escape_string($_POST['phone2']);
    $email1 = $conn->real_escape_string($_POST['email1']);
    $email2 = $conn->real_escape_string($_POST['email2']);

    $sql = "UPDATE employees SET 
        first_name='$first_name', 
        last_name='$last_name', 
        company='$company', 
        department='$department', 
        designation='$designation', 
        location='$location', 
        phone1='$phone1', 
        phone2='$phone2',
        email1='$email1',
        email2='$email2'
        WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: employee_list.php");
        exit;
    } else {
        echo "Update failed: " . $conn->error;
    }
} else {
    // Show form
    $res = $conn->query("SELECT * FROM employees WHERE id=$id");
    $emp = $res->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand mb-0 h1">Employee Master</span>
    <div>
        <a href="add_employee.php" class="text-white text-decoration-none me-3">
            <i class="bi bi-person-plus-fill"></i> Add Employee
        </a>
        <a href="employee_list.php" class="text-white text-decoration-none">
            <i class="bi bi-people-fill"></i> Employee List
        </a>
    </div>
</nav>

<div class="container mt-5">
    <h3 class="mb-4">Edit Employee</h3>
    <form method="POST" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">First Name *</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars($emp['first_name']) ?>" class="form-control form-control-sm" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Last Name *</label>
            <input type="text" name="last_name" value="<?= htmlspecialchars($emp['last_name']) ?>" class="form-control form-control-sm" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Company *</label>
            <input type="text" name="company" value="<?= htmlspecialchars($emp['company']) ?>" class="form-control form-control-sm" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Department</label>
            <input type="text" name="department" value="<?= htmlspecialchars($emp['department']) ?>" class="form-control form-control-sm">
        </div>
        <div class="col-md-4">
            <label class="form-label">Designation</label>
            <input type="text" name="designation" value="<?= htmlspecialchars($emp['designation']) ?>" class="form-control form-control-sm">
        </div>
        <div class="col-md-4">
            <label class="form-label">Location</label>
            <input type="text" name="location" value="<?= htmlspecialchars($emp['location']) ?>" class="form-control form-control-sm">
        </div>

        <div class="col-md-4">
            <label class="form-label">Phone 1</label>
            <input type="text" name="phone1" value="<?= htmlspecialchars($emp['phone1']) ?>" class="form-control form-control-sm">
        </div>
        <div class="col-md-4">
            <label class="form-label">Phone 2</label>
            <input type="text" name="phone2" value="<?= htmlspecialchars($emp['phone2']) ?>" class="form-control form-control-sm">
        </div>

        <div class="col-md-4">
            <label class="form-label">Email 1</label>
            <input type="email" name="email1" value="<?= htmlspecialchars($emp['email1']) ?>" class="form-control form-control-sm">
        </div>
        <div class="col-md-4">
            <label class="form-label">Email 2</label>
            <input type="email" name="email2" value="<?= htmlspecialchars($emp['email2']) ?>" class="form-control form-control-sm">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-sm">Update</button>
            <a href="employee_list.php" class="btn btn-secondary btn-sm">Cancel</a>
        </div>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    © 2025 BCPDR System. All rights reserved.
</footer>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</body>
</html>
