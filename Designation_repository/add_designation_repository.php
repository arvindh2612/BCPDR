<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp = $_POST['employee_code'];
    $dept = $_POST['department_code'];
    $loc = $_POST['location_code'];
    $desg = $_POST['designation_name'];
    $current = $_POST['current_in_position'];
    $start = $_POST['start_date'];
    $end = $current === 'Y' ? NULL : $_POST['end_date'];

    $stmt = $conn->prepare("INSERT INTO DESIGNATION_REPOSITORY (EmployeeCode, DepartmentCode, LocationCode, DesignationName, CurrentInPosition, StartDate, EndDate) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $emp, $dept, $loc, $desg, $current, $start, $end);
    $stmt->execute();

    header("Location: list_designation_repository.php");
    exit;
}

// Fetch employee codes
$employeeResult = $conn->query("SELECT employee_code FROM employees ORDER BY employee_code");

// Fetch departments
$departmentResult = $conn->query("SELECT DepartmentCode, DepartmentName FROM department_master ORDER BY DepartmentName");

// Fetch locations
$locationResult = $conn->query("SELECT location_code, location_name FROM locations ORDER BY location_name");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Designation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Add Designation</span>
        <span class="text-light">
            <a href="add_designation_repository.php" class="text-light text-decoration-none me-3">🏢 Add </a>
            <a href="list_designation_repository.php" class="text-light text-decoration-none">📋 List</a>
        </span>
    </div>
</nav>
<div class="container mt-4">
    <form method="post" class="row g-3">
        <div class="col-md-4">
            <label>Employee Code</label>
            <select name="employee_code" class="form-select" required>
                <option value="">-- Select Employee --</option>
                <?php while ($row = $employeeResult->fetch_assoc()) : ?>
                    <option value="<?= htmlspecialchars($row['employee_code']) ?>">
                        <?= htmlspecialchars($row['employee_code']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label>Department Code</label>
            <select name="department_code" class="form-select" required>
                <option value="">-- Select Department --</option>
                <?php while ($row = $departmentResult->fetch_assoc()) : ?>
                    <option value="<?= htmlspecialchars($row['DepartmentCode']) ?>">
                        <?= htmlspecialchars($row['DepartmentName']) ?> (<?= htmlspecialchars($row['DepartmentCode']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label>Location Code</label>
            <select name="location_code" class="form-select" required>
                <option value="">-- Select Location --</option>
                <?php while ($row = $locationResult->fetch_assoc()) : ?>
                    <option value="<?= htmlspecialchars($row['location_code']) ?>">
                        <?= htmlspecialchars($row['location_name']) ?> (<?= htmlspecialchars($row['location_code']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label>Designation Name</label>
            <input type="text" name="designation_name" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label>Current In Position</label>
            <select name="current_in_position" class="form-select" required onchange="toggleEndDate(this)">
                <option value="Y">Y</option>
                <option value="N">N</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="col-md-3" id="endDateGroup">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <div class="col-md-12">
            <button class="btn btn-success">Save</button>
        </div>
    </form>
</div>
<br>

<script>
function toggleEndDate(select) {
    document.getElementById('endDateGroup').style.display = (select.value === 'Y') ? 'none' : 'block';
}
window.onload = () => toggleEndDate(document.querySelector('[name="current_in_position"]'));
</script>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
