<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

$empCode = $_GET['emp'] ?? '';
if (!$empCode) {
    header("Location: list_designation_repository.php");
    exit;
}

// Fetch current designation data
$stmt = $conn->prepare("SELECT * FROM DESIGNATION_REPOSITORY WHERE EmployeeCode = ?");
$stmt->bind_param("s", $empCode);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
if (!$data) {
    header("Location: list_designation_repository.php");
    exit;
}

// Fetch employees for dropdown
$employeeResult = $conn->query("SELECT employee_code FROM employees ORDER BY employee_code");

// Fetch departments for dropdown
$departmentResult = $conn->query("SELECT DepartmentCode, DepartmentName FROM department_master ORDER BY DepartmentName");

// Fetch locations for dropdown
$locationResult = $conn->query("SELECT location_code, location_name FROM locations ORDER BY location_name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp = $_POST['employee_code'];
    $dept = $_POST['department_code'];
    $loc = $_POST['location_code'];
    $desg = $_POST['designation_name'];
    $current = $_POST['current_in_position'];
    $start = $_POST['start_date'];
    $end = empty($_POST['end_date']) ? NULL : $_POST['end_date'];

    $stmt = $conn->prepare("UPDATE DESIGNATION_REPOSITORY SET EmployeeCode=?, DepartmentCode=?, LocationCode=?, DesignationName=?, CurrentInPosition=?, StartDate=?, EndDate=? WHERE EmployeeCode=?");
    $stmt->bind_param("ssssssss", $emp, $dept, $loc, $desg, $current, $start, $end, $empCode);
    $stmt->execute();

    header("Location: list_designation_repository.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Designation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <span class="navbar-brand mb-0 h1">Edit Designation</span>
        <a href="list_designation_repository.php" class="text-light text-decoration-none">← Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <form method="post" class="row g-3">
        <div class="col-md-4">
            <label>Employee Code</label>
            <select name="employee_code" class="form-select" required>
                <option value="">-- Select Employee --</option>
                <?php while ($row = $employeeResult->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['employee_code']) ?>" <?= ($row['employee_code'] === $data['EmployeeCode']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['employee_code']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label>Department Code</label>
            <select name="department_code" class="form-select" required>
                <option value="">-- Select Department --</option>
                <?php while ($row = $departmentResult->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['DepartmentCode']) ?>" <?= ($row['DepartmentCode'] === $data['DepartmentCode']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['DepartmentName']) ?> (<?= htmlspecialchars($row['DepartmentCode']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label>Location Code</label>
            <select name="location_code" class="form-select" required>
                <option value="">-- Select Location --</option>
                <?php while ($row = $locationResult->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['location_code']) ?>" <?= ($row['location_code'] === $data['LocationCode']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['location_name']) ?> (<?= htmlspecialchars($row['location_code']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label>Designation Name</label>
            <input type="text" name="designation_name" value="<?= htmlspecialchars($data['DesignationName']) ?>" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label>Current In Position</label>
            <select name="current_in_position" class="form-select" required>
                <option value="Y" <?= $data['CurrentInPosition'] === 'Y' ? 'selected' : '' ?>>Y</option>
                <option value="N" <?= $data['CurrentInPosition'] === 'N' ? 'selected' : '' ?>>N</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Start Date</label>
            <input type="date" name="start_date" value="<?= htmlspecialchars($data['StartDate']) ?>" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($data['EndDate']) ?>">
        </div>
<br>
        <div class="col-md-12">
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
</div><br><br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
