<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch companies
$companies = $conn->query("SELECT CompanyCode, CompanyName FROM CompanyMaster");

// Fetch departments
$departments = $conn->query("SELECT DepartmentCode, DepartmentName FROM department_master");

// Fetch distinct designations
$designations = $conn->query("SELECT DISTINCT DesignationName FROM DESIGNATION_REPOSITORY");

// Fetch locations
$locations = $conn->query("SELECT location_code, location_name FROM locations");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_code = $_POST['employee_code'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $company = $_POST['company'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $location = $_POST['location'];
    $phone1 = $_POST['phone1'];
    $phone2 = $_POST['phone2'];
    $email1 = $_POST['email1'];
    $email2 = $_POST['email2'];

    $sql = "INSERT INTO employees (employee_code, first_name, middle_name, last_name, company, department, designation, location, phone1, phone2, email1, email2)
            VALUES ('$employee_code', '$first_name', '$middle_name', '$last_name', '$company', '$department', '$designation', '$location', '$phone1', '$phone2', '$email1', '$email2')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Employee added successfully'); window.location='add_employee.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
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
        <span class="navbar-brand mb-0 h1">Employee Master</span>
        <span class="text-light">
            <a href="add_employee.php" class="text-light text-decoration-none me-3">👤 Add Employee</a>
            <a href="employee_list.php" class="text-light text-decoration-none">👥 Employee List</a>
        </span>
    </div>
</nav>

<div class="container">
    <div class="form-container">
        <h2 class="mb-4">Add Employee</h2>
        <form method="post">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Employee Code *</label>
                    <input type="text" name="employee_code" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>First Name *</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Last Name *</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Company *</label>
                    <select name="company" class="form-control" required>
                        <option value="">Select Company</option>
                        <?php while ($row = $companies->fetch_assoc()) { ?>
                            <option value="<?= $row['CompanyCode']; ?>"><?= $row['CompanyName']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Department *</label>
                    <select name="department" class="form-control" required>
                        <option value="">Select Department</option>
                        <?php while ($row = $departments->fetch_assoc()) { ?>
                            <option value="<?= $row['DepartmentCode']; ?>"><?= $row['DepartmentName']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Designation *</label>
                    <select name="designation" class="form-control" required>
                        <option value="">Select Designation</option>
                        <?php while ($row = $designations->fetch_assoc()) { ?>
                            <option><?= $row['DesignationName']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Location *</label>
                    <select name="location" class="form-control" required>
                        <option value="">Select Location</option>
                        <?php while ($row = $locations->fetch_assoc()) { ?>
                            <option value="<?= $row['location_code']; ?>"><?= $row['location_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Phone Number 1 *</label>
                    <input type="text" name="phone1" class="form-control" required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label>Phone Number 2</label>
                    <input type="text" name="phone2" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Email Address 1 *</label>
                    <input type="email" name="email1" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Email Address 2</label>
                    <input type="email" name="email2" class="form-control">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Add Employee</button>
                <a href="employee_list.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
