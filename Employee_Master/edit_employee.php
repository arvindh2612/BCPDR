<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) die("Invalid request");

// Fetch dropdown data
$companies = $conn->query("SELECT CompanyName FROM CompanyMaster");
$departments = $conn->query("SELECT DepartmentName FROM department_master");
$designations = $conn->query("SELECT DISTINCT DesignationName FROM DESIGNATION_REPOSITORY WHERE CurrentInPosition='Y'");
$locations = $conn->query("SELECT location_name FROM locations");

// Process update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    $res = $conn->query("SELECT * FROM employees WHERE id=$id");
    if (!$res) {
        die("Error fetching employee data: " . $conn->error);
    }
    $emp = $res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- Navigation -->
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

<!-- Edit Form -->
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
            <select name="company" class="form-select form-select-sm" required>
                <option value="">--Select--</option>
                <?php while($row = $companies->fetch_assoc()): ?>
                    <option value="<?= $row['CompanyName'] ?>" <?= $emp['company'] == $row['CompanyName'] ? 'selected' : '' ?>>
                        <?= $row['CompanyName'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Department</label>
            <select name="department" class="form-select form-select-sm">
                <option value="">--Select--</option>
                <?php while($row = $departments->fetch_assoc()): ?>
                    <option value="<?= $row['DepartmentName'] ?>" <?= $emp['department'] == $row['DepartmentName'] ? 'selected' : '' ?>>
                        <?= $row['DepartmentName'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Designation</label>
            <select name="designation" class="form-select form-select-sm">
                <option value="">--Select--</option>
                <?php while($row = $designations->fetch_assoc()): ?>
                    <option value="<?= $row['DesignationName'] ?>" <?= $emp['designation'] == $row['DesignationName'] ? 'selected' : '' ?>>
                        <?= $row['DesignationName'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Location</label>
            <select name="location" class="form-select form-select-sm">
                <option value="">--Select--</option>
                <?php while($row = $locations->fetch_assoc()): ?>
                    <option value="<?= $row['location_name'] ?>" <?= $emp['location'] == $row['location_name'] ? 'selected' : '' ?>>
                        <?= $row['location_name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
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
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-save2-fill"></i> Update
            </button>
            <a href="employee_list.php" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Cancel
            </a>
        </div>

    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    © 2025 BCPDR System. All rights reserved.
</footer>

</body>
</html>
