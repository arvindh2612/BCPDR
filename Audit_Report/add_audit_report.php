<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch departments
$departments = [];
$result = $conn->query("SELECT DepartmentCode, DepartmentName FROM department_master");
while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
}

// Fetch employees
$employees = [];
$result = $conn->query("SELECT id, employee_code, first_name FROM employees");
while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $audit_no = $conn->real_escape_string($_POST["audit_no"]);
    $report_no = $conn->real_escape_string($_POST["report_no"]);
    $department_code = $conn->real_escape_string($_POST["department_code"]);
    $department_name = $conn->real_escape_string($_POST["department_name"]);
    $auditor_employee_code = $conn->real_escape_string($_POST["auditor_employee_code"]);
    $auditor_employee_name = $conn->real_escape_string($_POST["auditor_employee_name"]);
    $auditee_employee_code = $conn->real_escape_string($_POST["auditee_employee_code"]);
    $auditee_employee_name = $conn->real_escape_string($_POST["auditee_employee_name"]);
    $problems_identified = $conn->real_escape_string($_POST["problems_identified"]);
    $proposed_action = $conn->real_escape_string($_POST["proposed_action"]);
    $target_date = $conn->real_escape_string($_POST["target_date"]);

    $sql = "INSERT INTO audit_report (
                audit_no, report_no, department_code, department_name,
                auditor_employee_code, auditor_employee_name,
                auditee_employee_code, auditee_employee_name,
                problems_identified, proposed_action, target_date
            ) VALUES (
                '$audit_no', '$report_no', '$department_code', '$department_name',
                '$auditor_employee_code', '$auditor_employee_name',
                '$auditee_employee_code', '$auditee_employee_name',
                '$problems_identified', '$proposed_action', '$target_date'
            )";

    if ($conn->query($sql) === TRUE) {
        header("Location: audit_report_list.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Audit Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Add Audit Report</span>
        <a href="audit_report_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Add Audit Report</h2>
    <form method="post">
        <div class="mb-3">
            <label>AUDIT No.</label>
            <input type="text" name="audit_no" class="form-control" required maxlength="50">
        </div>
        <div class="mb-3">
            <label>REPORT No.</label>
            <input type="text" name="report_no" class="form-control" required maxlength="50">
        </div>

        <div class="mb-3">
            <label>DEPARTMENT</label>
            <select name="department_code" class="form-control" required onchange="updateDepartmentName(this)">
                <option value="">-- Select Department --</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept['DepartmentCode'] ?>" data-name="<?= $dept['DepartmentName'] ?>">
                        <?= $dept['DepartmentCode'] ?> - <?= $dept['DepartmentName'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="department_name" id="department_name">
        </div>

        <div class="mb-3">
            <label>AUDITOR EMPLOYEE</label>
            <select name="auditor_employee_code" class="form-control" required onchange="updateEmployeeName(this, 'auditor_employee_name')">
                <option value="">-- Select Auditor --</option>
                <?php foreach ($employees as $emp): ?>
                    <option value="<?= $emp['employee_code'] ?>" data-name="<?= $emp['first_name'] ?>">
                        <?= $emp['employee_code'] ?> - <?= $emp['first_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="auditor_employee_name" id="auditor_employee_name">
        </div>

        <div class="mb-3">
            <label>AUDITEE EMPLOYEE</label>
            <select name="auditee_employee_code" class="form-control" required onchange="updateEmployeeName(this, 'auditee_employee_name')">
                <option value="">-- Select Auditee --</option>
                <?php foreach ($employees as $emp): ?>
                    <option value="<?= $emp['employee_code'] ?>" data-name="<?= $emp['first_name'] ?>">
                        <?= $emp['employee_code'] ?> - <?= $emp['first_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="auditee_employee_name" id="auditee_employee_name">
        </div>

        <div class="mb-3">
            <label>Problems Identified / Potential Concerns</label>
            <textarea name="problems_identified" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label>Proposed Action to Prevent Recurrence of Root Cause</label>
            <textarea name="proposed_action" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label>Target Date</label>
            <input type="date" name="target_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Report</button>
    </form>
</div>

<script>
function updateDepartmentName(select) {
    const name = select.options[select.selectedIndex].getAttribute('data-name');
    document.getElementById('department_name').value = name;
}
function updateEmployeeName(select, inputId) {
    const name = select.options[select.selectedIndex].getAttribute('data-name');
    document.getElementById(inputId).value = name;
}
</script>
br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
