<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
$id = (int)$_GET['id'];

// Fetch existing CPAR record
$result = $conn->query("SELECT * FROM corrective_preventive_action_report WHERE id = $id");
$row = $result->fetch_assoc();

if (!$row) {
    header("Location: cpar_list.php");
    exit();
}

// Fetch employees for Employee Code dropdown
$employees = $conn->query("SELECT employee_code, first_name FROM employees ORDER BY employee_code");

// Fetch designation repository with CurrentInPosition='Y'
$designations = [];
$res = $conn->query("SELECT EmployeeCode, DepartmentCode, DesignationName FROM DESIGNATION_REPOSITORY WHERE CurrentInPosition = 'Y'");
while ($r = $res->fetch_assoc()) {
    $designations[$r['EmployeeCode']] = $r;
}

// Fetch departments
$departments = [];
$res = $conn->query("SELECT DepartmentCode, DepartmentName FROM department_master");
while ($r = $res->fetch_assoc()) {
    $departments[$r['DepartmentCode']] = $r['DepartmentName'];
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

    $conn->query("UPDATE corrective_preventive_action_report SET 
        employee_code='$employee_code',
        employee_name='$employee_name',
        designation='$designation',
        department='$department',
        action_date='$action_date',
        system_code='$system_code',
        system_name='$system_name',
        ref_transaction_batch_no='$ref_transaction_batch_no',
        problems_identified='$problems_identified',
        target_date='$target_date'
        WHERE id = $id");

    header("Location: cpar_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit CPAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Edit CPAR</span>
        <a href="cpar_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Edit Corrective/Preventive Action Report</h2>
    <form method="post" id="cparForm">
        <div class="mb-3">
            <label>Employee Code</label>
            <select name="employee_code" id="employee_code" class="form-select" required>
                <option value="" disabled>Select Employee Code</option>
                <?php while($emp = $employees->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($emp['employee_code']) ?>"
                        <?= ($emp['employee_code'] === $row['employee_code']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($emp['employee_code']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Employee Name</label>
            <input type="text" name="employee_name" id="employee_name" class="form-control" readonly required
                value="<?= htmlspecialchars($row['employee_name']) ?>">
        </div>
        <div class="mb-3">
            <label>Designation</label>
            <input type="text" name="designation" id="designation" class="form-control" readonly required
                value="<?= htmlspecialchars($row['designation']) ?>">
        </div>
        <div class="mb-3">
            <label>Department</label>
            <input type="text" name="department" id="department" class="form-control" readonly required
                value="<?= htmlspecialchars($row['department']) ?>">
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="action_date" class="form-control" required
                value="<?= htmlspecialchars($row['action_date']) ?>">
        </div>
        <div class="mb-3">
            <label>System Code</label>
            <select name="system_code" id="system_code" class="form-select" required>
                <option value="" disabled>Select System Code</option>
                <?php 
                // Reset pointer before loop
                $systems->data_seek(0);
                while($sys = $systems->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($sys['system_code']) ?>" data-name="<?= htmlspecialchars($sys['system_name']) ?>"
                        <?= ($sys['system_code'] === $row['system_code']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($sys['system_code']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>System Name</label>
            <input type="text" name="system_name" id="system_name" class="form-control" readonly required
                value="<?= htmlspecialchars($row['system_name']) ?>">
        </div>
        <div class="mb-3">
            <label>Ref/Transaction/Batch No.</label>
            <input type="text" name="ref_transaction_batch_no" class="form-control" required maxlength="50"
                value="<?= htmlspecialchars($row['ref_transaction_batch_no']) ?>">
        </div>
        <div class="mb-3">
            <label>Problems Identified / Potential Concerns</label>
            <textarea name="problems_identified" class="form-control" rows="4" required><?= htmlspecialchars($row['problems_identified']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Target Date</label>
            <input type="date" name="target_date" class="form-control" required
                value="<?= htmlspecialchars($row['target_date']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Report</button>
    </form>
</div>

<script>
// JS Data from PHP for designations and departments
const designations = <?= json_encode($designations) ?>;
const departments = <?= json_encode($departments) ?>;

// Employee code select change event to auto-fill designation, department, and employee name
document.getElementById('employee_code').addEventListener('change', function() {
    const empCode = this.value;
    if(designations[empCode]) {
        const designation = designations[empCode].DesignationName;
        const deptCode = designations[empCode].DepartmentCode;
        const deptName = departments[deptCode] || '';

        document.getElementById('designation').value = designation;
        document.getElementById('department').value = deptName;

        // Find employee first_name from employees list in JS or fetch via AJAX
        // Here, we'll do a simple lookup from a JS object built below:

        const employeeNames = {
            <?php
            // Prepare JS object mapping employee_code to first_name
            $empArr = [];
            $employees = $conn->query("SELECT employee_code, first_name FROM employees");
            while ($emp = $employees->fetch_assoc()) {
                $code = addslashes($emp['employee_code']);
                $name = addslashes($emp['first_name']);
                $empArr[] = "'$code': '$name'";
            }
            echo implode(",\n", $empArr);
            ?>
        };
        document.getElementById('employee_name').value = employeeNames[empCode] || '';
    } else {
        document.getElementById('designation').value = '';
        document.getElementById('department').value = '';
        document.getElementById('employee_name').value = '';
    }
});

// System code select change event to auto-fill system name
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
