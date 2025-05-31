<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");

// Fetch employees for Employee Code dropdown, include first_name
$employees = [];
$res = $conn->query("SELECT employee_code, first_name FROM employees ORDER BY employee_code");
while ($row = $res->fetch_assoc()) {
    $employees[$row['employee_code']] = $row['first_name'];
}

// Fetch designation repository with CurrentInPosition='Y'
$designations = [];
$res = $conn->query("SELECT EmployeeCode, DepartmentCode, DesignationName FROM DESIGNATION_REPOSITORY WHERE CurrentInPosition = 'Y'");
while ($row = $res->fetch_assoc()) {
    $designations[$row['EmployeeCode']] = $row;
}

// Fetch departments
$departments = [];
$res = $conn->query("SELECT DepartmentCode, DepartmentName FROM department_master");
while ($row = $res->fetch_assoc()) {
    $departments[$row['DepartmentCode']] = $row['DepartmentName'];
}

// Fetch systems for system code dropdown
$systems = $conn->query("SELECT system_code, system_name FROM system_master ORDER BY system_code");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_code = $conn->real_escape_string($_POST["employee_code"]);
    $employee_name = $conn->real_escape_string($_POST["employee_name"]);
    $designation = $conn->real_escape_string($_POST["designation"]);
    $department = $conn->real_escape_string($_POST["department"]);
    $action_date = $conn->real_escape_string($_POST["action_date"]);
    $system_code = $conn->real_escape_string($_POST["system_code"]);
    $system_name = $conn->real_escape_string($_POST["system_name"]);
    $ref_transaction_batch_no = $conn->real_escape_string($_POST["ref_transaction_batch_no"]);
    $problems_identified = $conn->real_escape_string($_POST["problems_identified"]);
    $target_date = $conn->real_escape_string($_POST["target_date"]);

    $conn->query("INSERT INTO corrective_preventive_action_report 
    (employee_code, first_name, designation, department, action_date, system_code, system_name, ref_transaction_batch_no, problems_identified, target_date)
    VALUES ('$employee_code', '$employee_name', '$designation', '$department', '$action_date', '$system_code', '$system_name', '$ref_transaction_batch_no', '$problems_identified', '$target_date')");

    header("Location: cpar_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Corrective/Preventive Action Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Add CPAR</span>
        <a href="cpar_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Add Corrective/Preventive Action Report</h2>
    <form method="post" id="cparForm">
        <div class="mb-3">
            <label>Employee Code</label>
            <select name="employee_code" id="employee_code" class="form-select" required>
                <option value="" disabled selected>Select Employee Code</option>
                <?php foreach ($employees as $code => $name): ?>
                    <option value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($code) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Employee Name</label>
            <input type="text" name="employee_name" id="employee_name" class="form-control" readonly required>
        </div>
        <div class="mb-3">
            <label>Designation</label>
            <input type="text" name="designation" id="designation" class="form-control" readonly required>
        </div>
        <div class="mb-3">
            <label>Department</label>
            <input type="text" name="department" id="department" class="form-control" readonly required>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="action_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>System Code</label>
            <select name="system_code" id="system_code" class="form-select" required>
                <option value="" disabled selected>Select System Code</option>
                <?php while($sys = $systems->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($sys['system_code']) ?>" data-name="<?= htmlspecialchars($sys['system_name']) ?>">
                        <?= htmlspecialchars($sys['system_code']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>System Name</label>
            <input type="text" name="system_name" id="system_name" class="form-control" readonly required>
        </div>
        <div class="mb-3">
            <label>Ref/Transaction/Batch No.</label>
            <input type="text" name="ref_transaction_batch_no" class="form-control" required maxlength="50">
        </div>
        <div class="mb-3">
            <label>Problems Identified / Potential Concerns</label>
            <textarea name="problems_identified" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label>Target Date</label>
            <input type="date" name="target_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Report</button>
    </form>
</div>

<script>
// JS Data from PHP for designations, departments, and employees
const designations = <?= json_encode($designations) ?>;
const departments = <?= json_encode($departments) ?>;
const employees = <?= json_encode($employees) ?>;

document.getElementById('employee_code').addEventListener('change', function() {
    const empCode = this.value;
    // Set employee name
    document.getElementById('employee_name').value = employees[empCode] || '';

    if(designations[empCode]) {
        const designation = designations[empCode].DesignationName;
        const deptCode = designations[empCode].DepartmentCode;
        const deptName = departments[deptCode] || '';

        document.getElementById('designation').value = designation;
        document.getElementById('department').value = deptName;
    } else {
        document.getElementById('designation').value = '';
        document.getElementById('department').value = '';
    }
});

document.getElementById('system_code').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const systemName = selectedOption.getAttribute('data-name') || '';
    document.getElementById('system_name').value = systemName;
});
</script>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
