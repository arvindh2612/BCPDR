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

// Get audit_no from URL and fetch existing audit report data
if (!isset($_GET['audit_no'])) {
    die("No audit_no provided");
}
$audit_no = $conn->real_escape_string($_GET['audit_no']);

$sql = "SELECT * FROM audit_report WHERE audit_no = '$audit_no'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("Audit report not found");
}
$audit = $result->fetch_assoc();

// Handle form submission for update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $update_sql = "UPDATE audit_report SET 
        report_no = '$report_no',
        department_code = '$department_code',
        department_name = '$department_name',
        auditor_employee_code = '$auditor_employee_code',
        auditor_employee_name = '$auditor_employee_name',
        auditee_employee_code = '$auditee_employee_code',
        auditee_employee_name = '$auditee_employee_name',
        problems_identified = '$problems_identified',
        proposed_action = '$proposed_action',
        target_date = '$target_date'
        WHERE audit_no = '$audit_no'";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: audit_report_list.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Audit Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Edit Audit Report</span>
        <a href="audit_report_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Edit Audit Report</h2>
    <form method="post">
        <div class="mb-3">
            <label>AUDIT No.</label>
            <!-- Audit No is primary key, so readonly -->
            <input type="text" name="audit_no" class="form-control" value="<?= htmlspecialchars($audit['audit_no']) ?>" readonly>
        </div>
        <div class="mb-3">
            <label>REPORT No.</label>
            <input type="text" name="report_no" class="form-control" required maxlength="50" value="<?= htmlspecialchars($audit['report_no']) ?>">
        </div>

        <div class="mb-3">
            <label>DEPARTMENT</label>
            <select name="department_code" class="form-control" required onchange="updateDepartmentName(this)">
                <option value="">-- Select Department --</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept['DepartmentCode'] ?>" data-name="<?= htmlspecialchars($dept['DepartmentName']) ?>"
                        <?= ($dept['DepartmentCode'] == $audit['department_code']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dept['DepartmentCode']) ?> - <?= htmlspecialchars($dept['DepartmentName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="department_name" id="department_name" value="<?= htmlspecialchars($audit['department_name']) ?>">
        </div>

        <div class="mb-3">
            <label>AUDITOR EMPLOYEE</label>
            <select name="auditor_employee_code" class="form-control" required onchange="updateEmployeeName(this, 'auditor_employee_name')">
                <option value="">-- Select Auditor --</option>
                <?php foreach ($employees as $emp): ?>
                    <option value="<?= $emp['employee_code'] ?>" data-name="<?= htmlspecialchars($emp['first_name']) ?>"
                        <?= ($emp['employee_code'] == $audit['auditor_employee_code']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($emp['employee_code']) ?> - <?= htmlspecialchars($emp['first_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="auditor_employee_name" id="auditor_employee_name" value="<?= htmlspecialchars($audit['auditor_employee_name']) ?>">
        </div>

        <div class="mb-3">
            <label>AUDITEE EMPLOYEE</label>
            <select name="auditee_employee_code" class="form-control" required onchange="updateEmployeeName(this, 'auditee_employee_name')">
                <option value="">-- Select Auditee --</option>
                <?php foreach ($employees as $emp): ?>
                    <option value="<?= $emp['employee_code'] ?>" data-name="<?= htmlspecialchars($emp['first_name']) ?>"
                        <?= ($emp['employee_code'] == $audit['auditee_employee_code']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($emp['employee_code']) ?> - <?= htmlspecialchars($emp['first_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="auditee_employee_name" id="auditee_employee_name" value="<?= htmlspecialchars($audit['auditee_employee_name']) ?>">
        </div>

        <div class="mb-3">
            <label>Problems Identified / Potential Concerns</label>
            <textarea name="problems_identified" class="form-control" rows="3" required><?= htmlspecialchars($audit['problems_identified']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Proposed Action to Prevent Recurrence of Root Cause</label>
            <textarea name="proposed_action" class="form-control" rows="3" required><?= htmlspecialchars($audit['proposed_action']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Target Date</label>
            <input type="date" name="target_date" class="form-control" required value="<?= htmlspecialchars($audit['target_date']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Report</button>
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

// Trigger the onchange handlers on page load to ensure hidden inputs have correct values
window.onload = function() {
    let deptSelect = document.querySelector('select[name="department_code"]');
    if (deptSelect) updateDepartmentName(deptSelect);

    let auditorSelect = document.querySelector('select[name="auditor_employee_code"]');
    if (auditorSelect) updateEmployeeName(auditorSelect, 'auditor_employee_name');

    let auditeeSelect = document.querySelector('select[name="auditee_employee_code"]');
    if (auditeeSelect) updateEmployeeName(auditeeSelect, 'auditee_employee_name');
}
</script>
</body>
br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</html>
